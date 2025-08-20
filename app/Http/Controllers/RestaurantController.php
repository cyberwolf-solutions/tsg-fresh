<?php

namespace App\Http\Controllers;

use App\Events\notifyBot;
use App\Events\notifyKot;
use App\Models\BookingsRooms;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Meal;
use App\Models\Modifier;
use App\Models\ModifiersCategories;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemModifier;
use App\Models\OrderNote;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Room;
use App\Models\SetMenu;
use App\Models\SetMenuMealType;
use App\Models\SetMenuType;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Modifiers;
use Carbon\Carbon;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $title = 'POS';

    //     $breadcrumbs = [
    //         // ['label' => 'First Level', 'url' => '', 'active' => false],
    //         ['label' => $title, 'url' => '', 'active' => true],
    //     ];

    //     $categories = Category::all()->where('type', 'Restaurant');
    //     $meals = Meal::all();
    //     $products = Product::all();


    //     // $items = $products->merge($setmenu);
    //     $items = $products->map(function($item) {
    //         $item->item_type = get_class($item);
    //         return $item;
    //     });

    //  return view('pos.restaurant.index', compact('title', 'breadcrumbs', 'categories', 'meals', 'products', 'items'));
    // }



    // public function index()
    // {
    //     $title = 'POS';

    //     $breadcrumbs = [
    //         ['label' => $title, 'url' => '', 'active' => true],
    //     ];

    //     $categories = Category::all();  // or filter if you want

    //     // Load inventory items with product & variant eager loaded, only with quantity > 0
    //     $items = Inventory::with(['product.categories', 'variant'])
    //         ->where('quantity', '>', 0)
    //         ->get()
    //         ->map(function ($item) {
    //             $obj = (object) $item->toArray();  // convert to stdClass to add dynamic props

    //             $name = $item->product ? $item->product->name : 'Unknown Product';
    //             if ($item->variant) {
    //                 $name .= ' - ' . $item->variant->variant_name;
    //             }
    //             $obj->full_name = $name;

    //             $obj->categories = $item->product ? $item->product->categories : collect();

    //             return $obj;
    //         });



    //     return view('pos.restaurant.index', compact(
    //         'title',
    //         'breadcrumbs',
    //         'categories',
    //         'items'
    //     ));
    // }


    public function index()
    {
        $title = 'POS';

        $breadcrumbs = [
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        $categories = Category::all();  // Or filter if needed

        // Load inventory items with product & variant eager loaded, only with quantity > 0
        $items = Inventory::with(['product.categories', 'variant'])
            ->where('quantity', '>', 0)
            ->get()
            ->map(function ($item) {
                $obj = (object) $item->toArray();  // convert to stdClass to add dynamic props
                $vid = null; // default
                // Compose full name with variant if exists
                $name = $item->product ? $item->product->name : 'Unknown Product';
                if ($item->variant) {
                    $name .= ' - ' . $item->variant->variant_name;
                    $vid = $item->variant->id;
                }
                $obj->full_name = $name;
                $obj->pname = $item->product->id;
                $obj->varientid =  $vid;

                // Categories from product relation
                $obj->categories = $item->product ? $item->product->categories : collect();

                // Add product image url, fallback to default if none
                $obj->product_image_url = $item->product && $item->product->image_url
                    ? 'uploads/products/' . $item->product->image_url
                    : 'uploads/cutlery.png';

                return $obj;
            });

        return view('pos.restaurant.index', compact(
            'title',
            'breadcrumbs',
            'categories',
            'items'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function note()
    {
        return view('pos.restaurant.notes');
    }
    public function process()
    {
        $inProgress = Order::where('status', 'Pending')->get();
        $ready = Order::where('status', 'InProgress')->get();
        return view('pos.restaurant.in-process', compact('inProgress', 'ready'));
    }


    public function customer(Request $request)
    {
        $customer = $request->customer;
        $customers = Customer::all();
        $currencies = Currency::all();

        return view('pos.restaurant.customer-modal', compact('customers', 'customer', 'currencies'));
    }
    public function customerAdd()
    {
        return view('pos.restaurant.customer-add-modal');
    }
    public function discount(Request $request)
    {
        $discount = $request->discount;
        $discount_method = $request->discount_method;
        return view('pos.restaurant.discount-modal', compact('discount', 'discount_method'));
    }
    public function vat(Request $request)
    {
        $vat = $request->vat;
        $vat_method = $request->vat_method;
        return view('pos.restaurant.vat-modal', compact('vat', 'vat_method'));
    }
    public function modifiers(Request $request)
    {
        $id = $request->id;
        $category = Product::find($id)->category_id;
        $modifiers = ModifiersCategories::where('category_id', $category)->get();
        return view('pos.restaurant.modifiers-modal', compact('modifiers', 'id'));
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required',
            'sub' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'vat' => 'required|numeric',
            'total' => 'nullable|numeric',
            'payment_note' => 'required|string',
            'coupon_code' => 'nullable|string',
            'coupon_type' => 'nullable|in:fixed,percentage',
            'coupon_value' => 'nullable|numeric|min:0',
            'total_bill' => 'required|numeric',
            'cash_received' => 'required|numeric',
            'cash_balance' => 'required|numeric',
            'ptype' => 'required',
        ]);

        if ($validator->fails()) {
            $all_errors = implode("<br>", $validator->errors()->all());
            return response()->json(['success' => false, 'message' => $all_errors]);
        }

        try {
            $sub = $request->sub; // original subtotal

            // 1️⃣ Coupon calculation
            $couponCode = $request->coupon_code;
            $couponType = $request->coupon_type;
            $couponValue = $request->coupon_value;

            $couponDiscount = 0;
            $couponId = null;

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->first();
                $couponId = $coupon?->id;

                if ($couponType === 'fixed') {
                    $couponDiscount = $couponValue;
                } elseif ($couponType === 'percentage') {
                    $couponDiscount = $sub * ($couponValue / 100);
                }
            }

            // 2️⃣ Subtotal after discount
            $discountedSub = max(0, $sub - $couponDiscount);

            // 3️⃣ VAT calculation (apply on discounted subtotal)
            $vatPercentage = $request->vat;
            $vatAmount = $discountedSub * ($vatPercentage / 100);

            // 4️⃣ Total
            $total = $discountedSub + $vatAmount;

            // 5️⃣ Create Order
            $order = Order::create([
                'customer_id'   => $request->customer,
                'order_date'    => now(),
                'subtotal'      => $sub,
                'discount'      => $couponDiscount, // store coupon discount
                'vat'           => $vatAmount,
                'total'         => $total,
                'coupon_id'     => $couponId,
                'coupon_code'   => $couponCode,
                'coupon_value'  => $couponValue,
                'coupon_type'   => $couponType,
                'created_by'    => Auth::id(),
            ]);

            if ($couponCode && $coupon) {
                $coupon->increment('used_count');

                // Create a coupon usage record
                CouponUsage::create([
                    'coupon_id'   => $coupon->id,
                    'customer_id' => $request->customer,
                    'order_id'    => $order->id,
                    'created_by'  => Auth::id(),
                ]);
            }
            // 6️⃣ Store Order Items and decrement inventory
            // 6️⃣ Store Order Items and decrement inventory
            $cart = json_decode($request->cart, true);
            foreach ($cart as $item) {
                $productId = trim($item['product_id']);
                $variantId = isset($item['variant_id']) ? trim($item['variant_id']) : null;

                $inventory = Inventory::where('product_id', $productId)
                    ->when($variantId !== null && $variantId !== '', fn($q) => $q->where('variant_id', $variantId), fn($q) => $q->whereNull('variant_id'))
                    ->first();

                Log::info('Inventory lookup', [
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'found' => $inventory?->id
                ]);

                if (!$inventory) {
                    Log::warning("Inventory not found for product_id: {$productId} variant_id: {$variantId}");
                    continue;
                }

                $qty = (int)($item['quantity'] ?? 1);
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $inventory->product_id,
                    'variant_id'   => $inventory->variant_id,
                    'inventory_id' => $inventory->id,
                    'quantity'     => $qty,
                    'price'        => $item['price'] ?? 0,
                    'total'        => ($item['price'] ?? 0) * $qty,
                    'created_by'   => Auth::id(),
                ]);

                $inventory->decrement('quantity', $qty);
            }


            // Save payment
            OrderPayment::create([
                'order_id' => $order->id,
                'date' => now()->format('Y-m-d'),
                'sub_total' => $request->sub,
                'vat' => $request->vat,
                'discount' => $request->discount,
                'total' => $request->total,
                'payment_type' => $request->ptype,
                'description' => 'Cash received: ' . $request->cash_received,
                'payment_status' => 'Paid',
                'receipt_no' => $request->dr ?? null,
                'created_by' => auth()->id(),
            ]);

            // 7️⃣ Loyalty points (10% of total bill)
            if ($order->customer_id && $order->customer_id != 0) {
                $customer = Customer::find($order->customer_id);
                if ($customer) {
                    $loyaltyPoints = $total * 0.10;
                    $customer->increment('loyality', $loyaltyPoints);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'url' => route('order.print', $order->id)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $th->getMessage()
            ]);
        }
    }

    public function recentOrders()
    {
        try {
            $orders = Order::with([
                'items.product',
                'items.variant',
                'customer',
                'payments'
            ])->latest()->take(10)->get();

            $data = $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_date' => $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('Y-m-d H:i') : 'N/A',
                    'customer_name' => $order->customer?->name ?? 'Walk-in',
                    'total' => $order->total ?? 0,
                    'items' => $order->items->map(function ($item) {
                        return [
                            'product_name' => $item->product?->name ?? 'N/A',
                            'variant_name' => $item->variant?->name ?? '',
                            'quantity' => $item->quantity ?? 0,
                            'price' => $item->price ?? 0,
                            'total' => $item->total ?? 0,
                        ];
                    }),
                    'payments' => $order->payments->map(function ($p) {
                        return [
                            'payment_type' => $p->payment_type,
                            'total' => $p->total ?? 0,
                            'status' => $p->payment_status,
                        ];
                    }),
                ];
            });

            return response()->json(['success' => true, 'orders' => $data]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $th->getMessage()
            ]);
        }
    }



    public function completeMeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $all_errors = null;

            foreach ($validator->errors()->messages() as $errors) {
                foreach ($errors as $error) {
                    $all_errors .= $error . "<br>";
                }
            }

            return response()->json(['success' => false, 'message' => $all_errors]);
        }
        try {
            $id = $request->id;
            $item = OrderItem::find($id);
            $item->updated_by = Auth::user()->id;
            $item->status = "Complete";
            $item->save();

            $order = Order::find($item->order_id);

            $totalItems = $order->items->count();
            $totalCompletedItems = $order->items->where('status',  'Complete')->count();

            $completedPercentage = $totalCompletedItems / $totalItems * 100;

            $order->progress = $completedPercentage;

            if ($totalItems == $totalCompletedItems) {
                $order->status = 'InProgress';
            }

            $order->save();

            return response()->json(['success' => true, 'message' => 'Order completed!']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function completeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $all_errors = null;

            foreach ($validator->errors()->messages() as $errors) {
                foreach ($errors as $error) {
                    $all_errors .= $error . "<br>";
                }
            }

            return response()->json(['success' => false, 'message' => $all_errors]);
        }
        try {
            $id = $request->id;

            $order = Order::find($id);
            $order->status = 'Complete';
            $order->save();



            return response()->json(['success' => true, 'message' => 'Order completed!']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function filterSetMenus(Request $request)
    {
        $setmenuTypeId = $request->input('setmenu_type_id');
        $setmenuMealTypeId = $request->input('setmenu_meal_type_id');
    }
}
