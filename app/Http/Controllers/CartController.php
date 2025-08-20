<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\DeliveryCharge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function index()
    {
        $tenant = tenant();

        if (!$tenant) {
            Log::error('Tenant not found');
            abort(404, 'Tenant not found');
        }

        $branch = $tenant->id;
        $domain = $tenant->domains()->first()?->domain;

        if (!$domain) {
            Log::error('Domain not found for tenant', ['tenant_id' => $tenant->id]);
            abort(404, 'Domain not found for the tenant');
        }

        // Get delivery charge for tenant
        $deliveryCharge = DeliveryCharge::where('tenant_id', $tenant->id)
            ->first()?->charge ?? 0;

        Log::info('Loading single product view for tenant and product', [
            'branch' => $branch,
            'domain' => $domain,
            'delivery_charge' => $deliveryCharge,
        ]);
        $billingAddress = null;
        if (Auth::guard('customer')->check()) {
            $billingAddress = BillingAddress::where('customer_id', Auth::guard('customer')->id())
                ->first();
        }



        return view('Landing-page.cart', [
            'tenant' => $tenant,
            'branch' => $branch,
            'domain' => $domain,
            'deliveryCharge' => $deliveryCharge,
            'billingAddress' => $billingAddress,
        ]);
    }


    public function addToCart(Request $request)
    {
        Log::info('--- addToCart started ---', [
            'session_id' => session()->getId(),
            'customer_id' => Auth::guard('customer')->id() ?? null,
            'request' => $request->except('password') // exclude sensitive fields if any
        ]);

        $customerId = Auth::guard('customer')->check()
            ? Auth::guard('customer')->id()
            : null;
        $sessionId  = session()->getId();

        Log::info('Customer and session info', compact('customerId', 'sessionId'));

        // Validate input
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'variant_id' => 'nullable|integer',
            'quantity'   => 'required|integer|min:1',
        ]);
        Log::info('Request validated', $validated);

        // Get inventory for product + variant
        $inventory = \App\Models\Inventory::query()
            ->where('product_id', $validated['product_id'])
            ->when($validated['variant_id'], fn($q, $v) => $q->where('variant_id', $v))
            ->first();

        if (!$inventory) {
            Log::warning('No inventory found', $validated);
            return response()->json(['success' => false, 'message' => 'No inventory found'], 404);
        }
        Log::info('Inventory found', ['inventory_id' => $inventory->id, 'quantity' => $inventory->quantity]);

        // Get or create cart
        $cart = Cart::firstOrCreate([
            'customer_id' => $customerId,
            'session_id'  => $sessionId,
        ]);
        Log::info('Cart retrieved or created', ['cart_id' => $cart->id]);

        // Find if already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $validated['product_id'])
            ->where('variant_id', $validated['variant_id'] ?? null)
            ->first();
        Log::info('Existing cart item found', ['cart_item_id' => $cartItem->id ?? null]);

        // Current quantity already in cart
        $currentQty = $cartItem ? $cartItem->quantity : 0;
        $newQty = $currentQty + $validated['quantity'];
        Log::info('Quantity calculation', ['current_qty' => $currentQty, 'new_qty' => $newQty]);

        // Check against stock
        if ($newQty > $inventory->quantity) {
            Log::warning('Quantity exceeds stock', [
                'requested_qty' => $newQty,
                'available_stock' => $inventory->quantity
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Only ' . $inventory->quantity . ' items available in stock',
            ], 400);
        }

        // Update or create cart item
        if ($cartItem) {
            $cartItem->update([
                'quantity' => $newQty,
                'total'    => $newQty * $inventory->unit_price,
            ]);
            Log::info('Cart item updated', ['cart_item_id' => $cartItem->id, 'new_qty' => $newQty]);
        } else {
            $cartItem = CartItem::create([
                'cart_id'      => $cart->id,
                'product_id'   => $validated['product_id'],
                'variant_id'   => $validated['variant_id'] ?? null,
                'inventory_id' => $inventory->id,
                'customer_id'  => $customerId,
                'session_id'   => $sessionId,
                'quantity'     => $validated['quantity'],
                'price'        => $inventory->unit_price,
                'total'        => $validated['quantity'] * $inventory->unit_price,
            ]);
            Log::info('Cart item created', ['cart_item_id' => $cartItem->id]);
        }

        Log::info('--- addToCart completed successfully ---', ['cart_item_id' => $cartItem->id]);

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'cart_item' => $cartItem,
        ]);
    }


    public function sidebar()
    {
        $customerId = Auth::guard('customer')->check()
            ? Auth::guard('customer')->id()
            : null;
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

        if ($cart && $cart->items) {
            foreach ($cart->items as $item) {
                $price = $item->variant ? $item->variant->variant_price : $item->product->price;
                $subtotal += $price * $item->quantity;
            }
        }
        // Total quantity in cart
        $count = $cart ? $cart->items->sum('quantity') : 0;
        return view('landing-page.partials.cart-items', compact('cart', 'subtotal', 'count'));
    }

    public function sidebar1()
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

        if ($cart && $cart->items) {
            foreach ($cart->items as $item) {
                $price = $item->variant ? $item->variant->variant_price : $item->product->price;
                $subtotal += $price * $item->quantity;
            }
        }
        // Total quantity in cart
        $count = $cart ? $cart->items->sum('quantity') : 0;
        return view('landing-page.partials.cart-table-items', compact('cart', 'subtotal', 'count'));
    }
    public function updateQuantity(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check stock quantity
        $stockQty = $item->inventory->quantity ?? 0;
        if ($request->quantity > $stockQty) {
            return response()->json([
                'success' => false,
                'message' => "Only {$stockQty} items available in stock"
            ], 400);
        }

        $item->quantity = $request->quantity;
        $item->total = $item->price * $item->quantity;
        $item->save();

        return response()->json([
            'success' => true,
            'quantity' => $item->quantity,
            'total' => $item->total
        ]);
    }
}
