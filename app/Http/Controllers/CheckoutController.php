<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\OrderItem;
use App\Models\BankDetail;
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

        // Use customer guard
        $customer = Auth::guard('customer')->check()
            ? WebCustomer::with('billingAddress')->find(Auth::guard('customer')->id())
            : null;



        $customerId = $customer?->id;
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
                $price = $item->variant ? $item->variant->final_price : $item->product->final_price;
                $subtotal += $price * $item->quantity;
                $totalQty += $item->quantity;
            }
        }

        // Apply discount if subtotal > 12500
        $discount = ($subtotal > 12500) ? $subtotal * 0.05 : 0;
        $total = $subtotal - $discount;

        $deliveryCharge = DeliveryCharge::where('tenant_id', $tenant->id)
            ->first()?->charge ?? 0;

        // Fetch billing address
        $billingAddress = $customer?->billingAddress;

        return view('Landing-page.checkout', compact(
            'cart',
            'subtotal',
            'discount',
            'total',
            'deliveryCharge',
            'customer',
            'billingAddress'
        ));
    }

    public function placeOrder(Request $request)
    {
        Log::info('--- Start placeOrder ---');
        Log::info($request);
        $customer = null;
        $oldSessionId = session()->getId();



        // 1. If user is not authenticated, create a new customer
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

                'delivery_date' => 'required|date_format:d/m/Y|after_or_equal:' . now()->format('d/m/Y'),
            ]);

            $deliveryDate = $request->delivery_date
                ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->delivery_date)->format('Y-m-d')
                : null;

            // Create new customer
            $customer = WebCustomer::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'password'   => bcrypt($request->password),
            ]);

            Log::info('New customer created', ['customer_id' => $customer->id]);

            // Create billing address
            $billing = BillingAddress::create([
                'customer_id'    => $customer->id,
                'first_name'     => $request->first_name,
                'last_name'      => $request->last_name,
                'street_address' => $request->address1,
                'town'           => $request->city,
                'phone'          => $request->phone,
                'email'          => $request->email,
            ]);

            Log::info('Billing address created', ['billing_id' => $billing->id]);

            // Login the new customer
            Auth::guard('customer')->login($customer);
            session()->regenerate(); // new session id
            $newSessionId = session()->getId();

            Log::info('Customer logged in', [
                'customer_id'    => $customer->id,
                'old_session_id' => $oldSessionId,
                'new_session_id' => $newSessionId,
            ]);

            // Transfer cart from guest session to customer
            $sessionCart = Cart::with('items.product', 'items.variant')
                ->where('session_id', $oldSessionId)
                ->first();

            if ($sessionCart) {
                $sessionCart->update([
                    'customer_id' => $customer->id,
                    'session_id'  => $newSessionId, // update to new session
                ]);

                Log::info('Cart transferred to customer', [
                    'cart_id'     => $sessionCart->id,
                    'customer_id' => $customer->id
                ]);
            }
        } else {
            // Already authenticated customer
            $customer = Auth::guard('customer')->user();
            Log::info('Authenticated user found', ['customer_id' => $customer->id]);
        }

        // 2. Retrieve customer cart
        $cart = Cart::with('items.product', 'items.variant')
            ->where('customer_id', $customer->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            Log::warning('Cart is empty', ['customer_id' => $customer->id ?? null]);
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        Log::info('Cart retrieved', [
            'cart_id'     => $cart->id,
            'items_count' => $cart->items->count()
        ]);


        // 3. Calculate totals
        $subtotal = $discount = $vat = $total = 0;
        foreach ($cart->items as $item) {
            $price = $item->variant ? $item->variant->final_price : $item->product->final_price;
            $subtotal += $price * $item->quantity;
        }
        $discount = ($subtotal > 12500) ? $subtotal * 0.05 : 0;
        // $vat      = ($subtotal - $discount) * 0.18;
        $vat      = 0;
        $total    = $subtotal - $discount + $vat;

        Log::info('Totals calculated', compact('subtotal', 'discount', 'vat', 'total'));

        // Apply coupon if available
        $couponSession = session('coupon');
        $couponDiscount = 0;

        if ($couponSession) {
            if ($couponSession['type'] === 'percent') {
                $couponDiscount = $subtotal * ($couponSession['value'] / 100);
            } else { // fixed value
                $couponDiscount = $couponSession['value'];
            }
        }

        // add normal discount (like 5% over 12500)
        $discount = ($subtotal > 12500) ? $subtotal * 0.05 : 0;
        $discount += $couponDiscount;  // include coupon

        $vat   = 0;
        // $vat   = ($subtotal - $discount) * 0.18;
        $total = $subtotal - $discount + $vat;

        Log::info('Totals calculated', compact('subtotal', 'discount', 'vat', 'total'));

        // Parse delivery date before order creation
        $deliveryDate = $request->delivery_date
            ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->delivery_date)->format('Y-m-d')
            : null;
        DB::beginTransaction();
        try {
            // 4. Create order
            $order = Order::create([
                'web_customer_id'  => $customer->id,
                'order_date'       => now(),
                'status'           => 'Pending',
                'subtotal'         => $subtotal,
                'total'            => $total,
                'discount'         => $discount,
                'vat'              => $vat,
                'source'           => 'WEB',
                'delivery_method'  => $request->delivery_method,
                'payment_method'   => $request->payment_method,
                'delivery_address' => $request->delivery_address,
                'delivery_date'   => $deliveryDate,
                'delivery_fee'  => $request->delivery_charge,
                'coupon_id'       => $couponSession['id'] ?? null,
                'coupon_code'     => $couponSession['code'] ?? null,
                'coupon_value'    => $couponSession['value'] ?? null,
                'coupon_type'     => $couponSession['type'] ?? null,
                'created_by'       => $customer->id,
            ]);

            Log::info('Order created', ['order_id' => $order->id]);

            if ($couponSession) {
                Coupon::where('id', $couponSession['id'])->increment('used_count');
                session()->forget('coupon'); // clear coupon after use
            }

            // 5. Create order items & reduce stock
            foreach ($cart->items as $item) {
                $price = $item->variant ? $item->variant->final_price : $item->product->final_price;

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'variant_id'   => $item->variant_id,
                    'inventory_id' => $item->inventory_id,
                    'price'        => $price,
                    'quantity'     => $item->quantity,
                    'total'        => $price * $item->quantity,
                    'created_by'   => $customer->id,
                ]);

                // Decrement stock
                if ($item->inventory_id) {
                    Inventory::where('id', $item->inventory_id)
                        ->decrement('quantity', $item->quantity);
                    Log::info('Inventory decremented', [
                        'inventory_id' => $item->inventory_id,
                        'quantity'     => $item->quantity
                    ]);
                } else {
                    Product::where('id', $item->product_id)
                        ->decrement('stock_qty', $item->quantity);
                    Log::info('Product stock decremented', [
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity
                    ]);
                }
            }

            // 6. Clear cart
            $cart->items()->delete();
            Log::info('Cart cleared', ['cart_id' => $cart->id]);

            DB::commit();
            // Clear applied coupon from session
            session()->forget('coupon');

            Log::info('--- Order placement successful ---', ['order_id' => $order->id]);
            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed successfully.');
            // Log::info('--- Order placement successful ---', ['order_id' => $order->id]);

            // return redirect()->route('order.print', $order->id)
            //     ->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order placement failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to place order. Please try again.');
        }
    }


    public function success($orderId)
    {
        $customerId = Auth::guard('customer')->id();

        // Get order from tenant DB
        $order = Order::with(['items.product', 'items.variant'])
            ->where('id', $orderId)
            ->where('web_customer_id', $customerId)
            ->first();

        if (!$order) {
            return redirect()->route('checkout.index')
                ->with('error', 'Order not found.');
        }

        // Get customer from central DB
        $customer = WebCustomer::with('billingAddress')->find($order->web_customer_id);

        // Get tenant bank details
        $tenantId = tenant('id'); // current tenant id
        $bankDetails = BankDetail::where('tenant_id', $tenantId)->first();

        return view('Landing-page.ordercomplete', compact('order', 'customer', 'bankDetails'));
    }


    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', $request->code)
            ->where('active', 1)
            ->where(function ($q) {
                $q->whereNull('expiry_date')->orWhere('expiry_date', '>=', now());
            })
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon.']);
        }

        // Get subtotal from current cart
        $cart = Cart::with('items.product', 'items.variant')
            ->where('session_id', session()->getId())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Cart is empty.']);
        }

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cart->items as $item) {
            $price = $item->variant ? $item->variant->final_price : $item->product->final_price;
            $subtotal += $price * $item->quantity;
        }

        // Calculate discount amount
        if ($coupon->type == 'fixed') {
            $discountValue = $coupon->value;
        } else { // percent
            $discountValue = $subtotal * ($coupon->value / 100);
        }

        // Save coupon in session
        session(['coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount' => $discountValue
        ]]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully.',
            'discount' => $discountValue
        ]);
    }
}
