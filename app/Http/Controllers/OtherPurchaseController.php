<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\Purchases;
use App\Models\Ingredient;
use App\Models\InventoryPurchaseItem;
use App\Models\InventoryPurchasePayment;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use App\Models\OtherPurchase;
use App\Models\Product;
use App\Models\PurchasePayment;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OtherPurchaseController extends Controller
{
    //
    public function index()
    {
        $title = 'Inventory Purchases';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = OtherPurchase::all();
        return view('pos.purchases.Other_index', compact('title', 'breadcrumbs', 'data'));
    }

    public function create()
    {
        $title = 'Inventory Purchase';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('opurchases.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $is_edit = false;

        $suppliers = Supplier::all();
        $products = Product::all();
        $unit = Unit::all();

        $latest = OtherPurchase::latest()->first();

        if ($latest) {
            $latest = $latest->id;
        } else {
            $latest = 0;
        }

        $latest++;

        return view('pos.purchases.Other_create-edit', compact('title', 'breadcrumbs', 'unit', 'is_edit', 'suppliers', 'products', 'latest'));
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'date' => 'required',
    //         'supplier' => 'required',
    //         'note' => 'nullable',
    //     ]);

    //     if ($validator->fails()) {
    //         $all_errors = null;

    //         foreach ($validator->errors()->messages() as $errors) {
    //             foreach ($errors as $error) {
    //                 $all_errors .= $error . "<br>";
    //             }
    //         }

    //         return response()->json(['success' => false, 'message' => $all_errors]);
    //     }

    //     // Retrieve products from the request
    //     $products = json_decode($request->input('products'), true);

    //     if (empty($products)) {
    //         return response()->json(['success' => false, 'message' => 'Select at least one item']);
    //     }

    //     try {

    //         // Calculate subtotal
    //         $subtotal = 0;
    //         foreach ($products as $product) {
    //             $subtotal += $product['price'] * $product['quantity'];
    //         }

    //         // Retrieve other form data
    //         $date = $request->input('date');
    //         $supplierId = $request->input('supplier');
    //         $note = $request->input('note');
    //         $discount = $request->input('discount');
    //         $vatPercentage = $request->input('vat_percentage');

    //         // Calculate total after discount and VAT
    //         $subtotalAfterDiscount = $subtotal - $discount;
    //         $vatAmount = ($subtotalAfterDiscount * $vatPercentage) / 100;
    //         $total = $subtotalAfterDiscount + $vatAmount;

    //         $data = [
    //             'date' => $date,
    //             'supplier_id' => $supplierId,
    //             'note' => $note,
    //             'sub_total' => $subtotal,
    //             'discount' => $discount,
    //             'vat' => $vatPercentage,
    //             'vat_amount' => $vatAmount,
    //             'total' => $total,
    //             'created_by' => Auth::user()->id,
    //         ];

    //         $purchase = OtherPurchase::create($data);

    //         foreach ($products as $product) {
    //             $data = [
    //                 'purchase_id' => $purchase->id,
    //                 'product_id' => $product['id'],
    //                 'price' => $product['price'],
    //                 'quantity' => $product['quantity'],
    //                 'total' => $product['price'] * $product['quantity'],
    //             ];
    //             InventoryPurchaseItem::create($data);
    //         }

    //         Supplier::where('id', $supplierId)->increment('balance', $total);

    //         return json_encode(['success' => true, 'message' => 'Purchase created', 'url' => route('opurchases.index')]);
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
    //     }
    // }





    public function store(Request $request)
    {

        //  dd($request->all()); 

        // // Convert JSON string to array
        // if ($request->filled('products')) {
        //     $request->merge([
        //         'products' => json_decode($request->products, true)
        //     ]);
        // }
        // // // Validate request data
        // // $validated = $request->validate([
        // //     'date' => 'required|date',
        // //     // 'supplier' => 'required|exists:suppliers,id',
        // //     'supplier' => 'required|exists:tenant.suppliers,id',
        // //     'note' => 'nullable|string',
        // //     // 'sub_total' => 'required|numeric|min:0',
        // //     'vat_percentage' => 'required|numeric|min:0',
        // //     // 'vat_amount' => 'required|numeric|min:0',
        // //     'discount' => 'required|numeric|min:0',
        // //     'total' => 'required|numeric|min:0',
        // //     // 'payment_status' => 'required|string',
        // //     'products' => 'required|array|min:1',
        // //     'products.*.product_id' => 'required|exists:products,id',
        // //     'products.*.variant_id' => 'nullable|exists:product_variants,id',
        // //     'products.*.buying_price' => 'required|numeric|min:0',
        // //     'products.*.quantity' => 'required|integer|min:1',
        // //     'products.*.unit' => 'required|string|max:50',
        // //     'products.*.total' => 'required|numeric|min:0',
        // //     'products.*.manufacture_date' => 'nullable|date|before_or_equal:today',
        // //     'products.*.expiry_date' => 'nullable|date|after_or_equal:today',
        // // ]);


        // $validated = $request->validate([
        //     'date' => 'required|date',
        //     'supplier' => 'required|exists:tenant.suppliers,id',
        //     'note' => 'nullable|string',
        //     'vat_percentage' => 'required|numeric|min:0',
        //     'discount' => 'required|numeric|min:0',
        //     'total' => 'required|numeric|min:0',
        //     'products' => 'required|array|min:1',
        //     'products.*.product_id' => 'required|exists:products,id',
        //     'products.*.variant_id' => 'nullable|exists:product_variants,id',
        //     'products.*.buying_price' => 'required|numeric|min:0',
        //     'products.*.quantity' => 'required|integer|min:1',
        //     'products.*.unit' => 'required|string|max:50',
        //     'products.*.total' => 'required|numeric|min:0',
        //     'products.*.manufacture_date' => 'nullable|date|before_or_equal:today',
        //     'products.*.expiry_date' => 'nullable|date|after_or_equal:today',
        // ]);

        if ($request->filled('products')) {
            $productsArray = json_decode($request->products, true);

            // Map your frontend keys to match validation rules
            $productsArray = array_map(function ($item) {
                return [
                    'product_id'       => $item['id'],
                    'variant_id'       => $item['variant_id'] ?? null,
                    'buying_price'     => $item['price'],
                    'quantity'         => $item['quantity'],
                    'unit'             => $item['unit'],
                    'total'            => $item['price'] * $item['quantity'],
                    'manufacture_date' => $item['mfd'] ?? null,
                    'expiry_date'      => $item['exp'] ?? null,
                ];
            }, $productsArray);

            $request->merge(['products' => $productsArray]);
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'supplier' => 'required|exists:tenant.suppliers,id',
            'products' => 'required|array|min:1',
            'discount' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'products.*.product_id' => 'required|exists:tenant.products,id',
            'products.*.variant_id' => 'nullable|exists:tenant.product_variants,id',
            'products.*.buying_price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit' => 'required|string|max:50',
            'products.*.total' => 'required|numeric|min:0',
            'products.*.manufacture_date' => 'nullable|date|before_or_equal:today',
            'products.*.expiry_date' => 'nullable|date|after_or_equal:today',
        ]);
        // Use DB transaction to ensure data integrity
        DB::beginTransaction();

        try {
            $purchase = OtherPurchase::create([
                'date' => $validated['date'],
                'supplier_id' => $validated['supplier'],
                'note' => $validated['note'] ?? null,
                'sub_total' => $request->subtotal ?? 0,
                'vat' => $request->vat ?? 0,
                'vat_amount' => $request->vat_amount ?? 0,
                'discount' => $validated['discount'],
                'total' => $validated['total'],
                'payment_status' => $request->payment_status ?? 'Unpaid',
                'created_by' => Auth::id(),
            ]);

            foreach ($validated['products'] as $itemData) {
                $purchase->items()->create([
                    'product_id' => $itemData['product_id'],
                    'variant_id' => $itemData['variant_id'] ?? null,
                    'buying_price' => $itemData['buying_price'],
                    'quantity' => $itemData['quantity'],
                    'unit' => $itemData['unit'],
                    'total' => $itemData['total'],
                    'manufacture_date' => $itemData['manufacture_date'] ?? null,
                    'expiry_date' => $itemData['expiry_date'] ?? null,
                    'created_by' => Auth::id(),
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Purchase saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Optional: log the full error for debugging
            Log::error('Purchase store error: ' . $e->getMessage());

            // Redirect back with error and old input
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to save purchase: ' . $e->getMessage());
        }
    }



    public function show(string $id)
    {
        $title = 'Inventory Purchase';

        $data = OtherPurchase::find($id);
        $settings = Settings::latest()->first();

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('opurchases.index'), 'active' => false],
            ['label' => $settings->otherpurchase($data->id), 'url' => '', 'active' => true],
        ];


        return view('pos.purchases.Other_show', compact('title', 'breadcrumbs', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Inventory Purchase Edit';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('opurchases.index'), 'active' => false],
            ['label' => 'Edit', 'url' => '', 'active' => true],
        ];

        $is_edit = true;

        $suppliers = Supplier::all();
        $products = Inventory::all();

        $data = OtherPurchase::find($id);

        return view('pos.purchases.Other_create-edit', compact('title', 'breadcrumbs', 'is_edit', 'data', 'suppliers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'supplier' => 'required',
            'note' => 'nullable',
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

        // Retrieve products from the request
        $products = json_decode($request->input('products'), true);

        if (empty($products)) {
            return response()->json(['success' => false, 'message' => 'Select at least one item']);
        }

        // Retrieve the purchase instance to update
        $purchase = OtherPurchase::findOrFail($id);

        try {

            // Calculate subtotal, discount, VAT, and total
            $subtotal = 0;
            foreach ($products as $product) {
                $subtotal += $product['price'] * $product['quantity'];
            }
            $discount = $request->input('discount');
            $vatPercentage = $request->input('vat_percentage');
            $subtotalAfterDiscount = $subtotal - $discount;
            $vatAmount = ($subtotalAfterDiscount * $vatPercentage) / 100;
            $total = $subtotalAfterDiscount + $vatAmount;

            // Update purchase details
            $purchase->update([
                'date' => $request->input('date'),
                'supplier_id' => $request->input('supplier'),
                'note' => $request->input('note'),
                'sub_total' => $subtotal,
                'discount' => $discount,
                'vat' => $vatPercentage,
                'vat_amount' => $vatAmount,
                'total' => $total,
                'updated_by' => Auth::user()->id,
            ]);

            // Delete items that are not in the new products array
            $existingProductIds = $purchase->items->pluck('product_id')->toArray();
            $newProductIds = collect($products)->pluck('id')->toArray();
            $productsToDelete = array_diff($existingProductIds, $newProductIds);
            InventoryPurchaseItem::whereIn('product_id', $productsToDelete)->delete();

            // Add new items to the purchase
            foreach ($products as $product) {
                $existingItem = $purchase->items()->where('product_id', $product['id'])->first();
                if ($existingItem) {
                    // Update existing item
                    $existingItem->update([
                        'price' => $product['price'],
                        'quantity' => $product['quantity'],
                        'total' => $product['price'] * $product['quantity'],
                    ]);
                } else {
                    // Create new item
                    $purchase->items()->create([
                        'product_id' => $product['id'],
                        'price' => $product['price'],
                        'quantity' => $product['quantity'],
                        'total' => $product['price'] * $product['quantity'],
                    ]);
                }
            }

            // Update supplier balance
            Supplier::where('id', $request->input('supplier'))->increment('balance', $total);

            return json_encode(['success' => true, 'message' => 'Purchase updated', 'url' => route('opurchases.index')]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }




    public function destroy(string $id)
    {
        try {
            // Find the purchase by id
            $purchase = OtherPurchase::findOrFail($id);

            // Update the 'deleted_by' field in the purchase record
            $purchase->update(['deleted_by' => Auth::user()->id]);

            // Find and delete purchase items associated with the purchase
            $items = InventoryPurchaseItem::where('purchase_id', $purchase->id)->get();
            foreach ($items as $item) {
                $item->delete();
            }

            // Find the supplier and update their balance
            $supplier = Supplier::findOrFail($purchase->supplier_id);
            $balance = $supplier->balance - $purchase->total;
            $supplier->update(['balance' => $balance]);

            // Delete the purchase record
            $purchase->delete();

            // Return a success response
            return json_encode(['success' => true, 'message' => 'Purchase deleted', 'url' => route('opurchases.index')]);
        } catch (\Throwable $th) {
            // Catch and return an error response
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }


    public function addPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'amount' => 'required',
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

            $id = decrypt($request->id);

            $purchaseOrder = OtherPurchase::find($id);

            $purchaseOrder = OtherPurchase::find($id);


            $total = $purchaseOrder->total;

            // Retrieve all payments for the purchase-order
            $payments = InventoryPurchasePayment::where('purchase_id', $purchaseOrder->id)->get();

            // Calculate the total amount paid, including the current payment
            $totalAmountPaid = $payments->sum('amount') + $request->amount;


            // Determine the payment status
            if ($totalAmountPaid >= $total) {
                $status = 'Paid';
            } elseif ($totalAmountPaid > 0) {
                $status = 'Partially Paid';
            } else {
                $status = 'Unpaid';
            }

            // Update the payment status in the database
            $purchaseOrder->update(['payment_status' => $status]);

            $data = [
                'purchase_id' => $purchaseOrder->id,
                'date' => $request->date,
                'amount' => $request->amount,
                'reference' => $request->reference,
                'description' => $request->description,
                'created_by' => Auth::user()->id,
            ];

            // Handle file upload for receipt
            if ($request->hasFile('receipt')) {
                $file = $request->file('receipt');

                // Generate a unique filename based on date and other details
                $fileName = sprintf(
                    'purchase_payment_%s_%s.%s', // Add placeholders for the purchase order ID and file extension
                    $purchaseOrder->id,
                    now()->format('YmdHis'), // Use the current date and time for uniqueness
                    $file->getClientOriginalExtension() // Get the original file extension
                );


                // Store the file with the custom name
                $filePath = $file->storeAs('receipts', $fileName, 'public');

                // Add the file path to the $data array
                $data['receipt'] = $filePath;
            }

            $payment = InventoryPurchasePayment::create($data);

            $supplier = Supplier::find($purchaseOrder->supplier_id);
            $balance = $supplier->balance - $request->amount;
            $supplier->update(['balance' => $balance]);

            return json_encode(['success' => true, 'message' => 'Payment Added', 'url' => route('opurchases.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function viewAddPayment(string $id)
    {
        $data = OtherPurchase::find(decrypt($id));

        $due = $data->total - $data->paymentSum();

        $is_edit = false;

        return view('pos.purchases.Other_payment', compact('data', 'is_edit', 'due'));
    }

    public function viewPayments(string $id)
    {
        // Assuming you want to fetch all payments related to a specific purchase
        $data = InventoryPurchasePayment::where('purchase_id', $id)->get();

        return view('pos.purchases.other_payments-modal', compact('data'));
    }
    public function purchaseReport()
    {
        $title = 'Purchase Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        // $data = Purchases::all();
        $data = Purchases::with(['supplier', 'items.product', 'payments'])->get();
        return view('pos.reports.purchaseReports', compact('data'));
    }
}
