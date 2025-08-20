<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
        $customerId = auth()->check() ? auth()->id() : null;
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

        return view('Landing-page.checkout', compact('cart', 'subtotal', 'discount', 'total'));
    }
    public function placeOrder(Request $request)
    {

        $user = auth()->guard('customer')->user(); // logged-in web customer

        $cart = Cart::with('items.product', 'items.variant')->where('session_id', session()->getId())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        $subtotal = 0;
        $total = 0;
        $discount = 0;
        $vat = 0;

        foreach ($cart->items as $item) {
            $price = $item->variant ? $item->variant->final_price : $item->product->final_price;
            $subtotal += $price * $item->quantity;
        }

        // Example discount logic
        if ($subtotal > 12500) {
            $discount = $subtotal * 0.05;
        }

        $vat = ($subtotal - $discount) * 0.18; // if 18% VAT
        $total = $subtotal - $discount + $vat;

        // Start DB transaction
        DB::beginTransaction();

        try {
            // 1. Create Order
            $order = Order::create([
                'web_customer_id' => $user->id ?? null,
                'order_date' => now(),
                'status' => 'Pending',
                'subtotal' => $subtotal,
                'total' => $total, // include discount, vat if any
                'discount' => $discount ?? 0,
                'vat' => $vat ?? 0,
                'coupon_id' => $cart->coupon_id ?? null,
                'coupon_code' => $cart->coupon_code ?? null,
                'coupon_value' => $cart->coupon_value ?? null,
                'coupon_type' => $cart->coupon_type ?? null,
                'source' => 'WEB',
                'delivery_method' => $request->delivery_method, // 'Pickup' or 'Shipping'
                'payment_method' => $request->payment_method,   // 'COD', 'Card', 'Bank'
                'delivery_address' => $request->delivery_address,
                'created_by' => $user->id ?? null
            ]);

            // 2. Insert order items and reduce stock
            foreach ($cart->items as $item) {
                $price = $item->variant ? $item->variant->final_price : $item->product->final_price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'inventory_id' => $item->inventory_id,
                    'price' => $price,
                    'quantity' => $item->quantity,
                    'total' => $price * $item->quantity,
                    'created_by' => $user->id ?? null
                ]);

                // 3. Reduce stock qty
                if ($item->inventory_id) {
                    Inventory::where('id', $item->inventory_id)
                        ->decrement('quantity', $item->quantity);
                } else {
                    // fallback if product has no inventory record
                    Product::where('id', $item->product_id)
                        ->decrement('stock_qty', $item->quantity);
                }
            }

            // 4. Clear cart
            $cart->items()->delete();

            DB::commit();
            return redirect()->route('checkout.success', $order->id)->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Option 1: Print and stop execution (for development)
            dd($e->getMessage(), $e->getTraceAsString());

            // Option 2: Log the error and show a simple message
            Log::error('Order placement failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'cart_id' => $cart->id ?? null,
                'user_id' => $user->id ?? null
            ]);

            return redirect()->back()->with('error', 'Failed to place order. Check logs for details.');
        }
    }
}
