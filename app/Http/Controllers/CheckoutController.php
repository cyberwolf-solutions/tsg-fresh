<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\OrderItem;
use App\Models\WebCustomer;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\DeliveryCharge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //
    // public function index()
    // {
    //     $tenant = tenant();

    //     if (!$tenant) {
    //         Log::error('Tenant not found');
    //         abort(404, 'Tenant not found');
    //     }

    //     $branch = $tenant->id;
    //     $domain = $tenant->domains()->first()?->domain;

    //     if (!$domain) {
    //         Log::error('Domain not found for tenant', ['tenant_id' => $tenant->id]);
    //         abort(404, 'Domain not found for the tenant');
    //     }

    //     Log::info('Loading single product view for tenant and product', [
    //         'branch' => $branch,
    //         'domain' => $domain,

    //     ]);

    //     return view('Landing-page.checkout', [
    //         'tenant' => $tenant,
    //         'branch' => $branch,
    //         'domain' => $domain,
    //     ]);
    // }

    public function index()
    {
        $tenant = tenant();

        $customerId = Auth::guard('customer')->check()
            ? Auth::guard('customer')->id()
            : null;

        $customer = Auth::guard('customer')->check()
            ? Auth::guard('customer')->user()
            : null;

        Log::info('Customer ID for checkout', ['customer_id' => $customerId]);
        $sessionId  = session()->getId();

        $cart = Cart::with('items.product', 'items.variant')
            ->where(function ($q) use ($customerId, $sessionId) {
                if ($customerId) {
                    $q->where('customer_id', $customerId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->first();

        $subtotal = 0;
        $totalQty = 0;

        if ($cart && $cart->items) {
            foreach ($cart->items as $item) {
                $price = $item->variant ? $item->variant->variant_price : $item->product->price;
                $subtotal += $price * $item->quantity;
                $totalQty += $item->quantity;
            }
        }

        $deliveryCharge = DeliveryCharge::where('tenant_id', $tenant->id)
            ->first()?->charge ?? 0;
        // Apply discount if subtotal > 12500
        $discount = ($subtotal > 12500) ? $subtotal * 0.05 : 0;
        $total = $subtotal - $discount;

        return view('Landing-page.checkout', compact('cart', 'subtotal', 'discount', 'total', 'customer', 'deliveryCharge'));
    }
    public function placeOrder(Request $request)
    {
        Log::info('--- Start placeOrder ---');

        $customer = null;

        // 1. If user is not authenticated, create a new customer first
        if (!Auth::guard('customer')->check()) {
            Log::info('User not authenticated, validating input for new customer.');

            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'nullable|string|max:255',
                'email'      => 'required|email|unique:central.web_customers,email',
                'password'   => 'required|string|min:6',
                'address1'   => 'required|string',
                'city'       => 'required|string',
                'phone'      => 'required|string',
            ]);

            $customer = WebCustomer::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'password'   => bcrypt($request->password),
            ]);

            Log::info('New customer created', ['customer_id' => $customer->id]);

            // Create billing address
            $billing = BillingAddress::create([
                'customer_id'   => $customer->id,
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'street_address' => $request->address1,
                'town'          => $request->city,
                'phone'         => $request->phone,
                'email'         => $request->email,
            ]);

            Log::info('Billing address created', ['billing_id' => $billing->id]);

            // Login the new customer
            Auth::guard('customer')->login($customer);
            Log::info('Customer logged in', ['customer_id' => $customer->id]);

            // CRITICAL: Transfer cart from session to customer
            $sessionCart = Cart::with('items.product', 'items.variant')
                ->where('session_id', session()->getId())
                ->first();

            if ($sessionCart) {
                // Update cart with customer ID
                $sessionCart->update(['customer_id' => $customer->id]);
                Log::info('Cart transferred to customer', [
                    'cart_id' => $sessionCart->id,
                    'customer_id' => $customer->id
                ]);
            }
        } else {
            $customer = Auth::guard('customer')->user();
            Log::info('Authenticated user found', ['customer_id' => $customer->id]);
        }

        // 2. Retrieve cart (now it should find the customer's cart)
        $cart = Cart::with('items.product', 'items.variant')
            ->where('customer_id', $customer->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            Log::warning('Cart is empty', ['customer_id' => $customer->id ?? null]);
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        Log::info('Cart retrieved', [
            'cart_id' => $cart->id,
            'items_count' => $cart->items->count()
        ]);

        // 3. Calculate totals, discounts, VAT, etc.
        $subtotal = $discount = $vat = $total = 0;
        foreach ($cart->items as $item) {
            $price = $item->variant ? $item->variant->variant_price : $item->product->price;
            $subtotal += $price * $item->quantity;
        }
        $discount = ($subtotal > 12500) ? $subtotal * 0.05 : 0;
        $vat = ($subtotal - $discount) * 0.18;
        $total = $subtotal - $discount + $vat;

        Log::info('Totals calculated', compact('subtotal', 'discount', 'vat', 'total'));

        DB::beginTransaction();
        try {
            // 4. Create order
            $order = Order::create([
                'web_customer_id' => $customer->id,
                'order_date' => now(),
                'status' => 'Pending',
                'subtotal' => $subtotal,
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'source' => 'WEB',
                'delivery_method' => $request->delivery_method,
                'payment_method' => $request->payment_method,
                'delivery_address' => $request->delivery_address,
                'created_by' => $customer->id,
            ]);

            Log::info('Order created', ['order_id' => $order->id]);

            // 5. Insert order items and reduce stock
            foreach ($cart->items as $item) {
                $price = $item->variant ? $item->variant->variant_price : $item->product->price;
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'inventory_id' => $item->inventory_id,
                    'price' => $price,
                    'quantity' => $item->quantity,
                    'total' => $price * $item->quantity,
                    'created_by' => $customer->id
                ]);

                Log::info('Order item created', ['order_item_id' => $orderItem->id]);

                if ($item->inventory_id) {
                    Inventory::where('id', $item->inventory_id)->decrement('quantity', $item->quantity);
                    Log::info('Inventory decremented', ['inventory_id' => $item->inventory_id, 'quantity' => $item->quantity]);
                } else {
                    Product::where('id', $item->product_id)->decrement('stock_qty', $item->quantity);
                    Log::info('Product stock decremented', ['product_id' => $item->product_id, 'quantity' => $item->quantity]);
                }
            }

            // 6. Clear cart
            $cart->items()->delete();
            Log::info('Cart cleared', ['cart_id' => $cart->id]);

            DB::commit();

            Log::info('--- Order placement successful ---', ['order_id' => $order->id]);
            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order placement failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to place order. Please try again.');
        }
    }
}
