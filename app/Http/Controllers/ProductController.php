<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\MealsProducts;
use App\Models\Product;
use App\Models\ProductsIngredients;
use App\Models\Settings;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductVariant;
use App\Models\Unit;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Products';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data =  Product::with('categories')->get();


        return view('pos.products.index', compact('title', 'breadcrumbs', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Products';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('products.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $is_edit = false;
        $ingredients = Brand::all();
        $categories = Category::all();
        $unit = Unit::all();

        return view('pos.products.create-edit', compact('title', 'breadcrumbs', 'is_edit', 'unit', 'categories', 'ingredients'));
    }



    public function store(Request $request)
    {
        $tableData = json_decode($request->input('table_data'), true);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products,name',
            'pcode' => 'required',
            'barcode' => 'required',
            'brand' => 'required',
            'punit' => 'required',
            'cost' => 'required',
            'pprice' => 'required',
            'qty' => 'required',
            'tax' => 'required',
            'taxmethod' => 'required',
            'taxstatus' => 'required',
            'taxclass' => 'required',
            'ptype' => 'required',
            'productDetails' => 'required',
            'image' => 'nullable|max:5000',

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

        $image_url = null;

        if ($request->file('image') != null) {
            $preferred_name = trim($request->name);
            $image_url = $preferred_name . '.' . $request['image']->extension();
        }

        try {


            $status = $request->has('status') ? 'private' : 'public';

            $product_price = $request->pprice;
            $tax = $request->tax;
            $tax_status = $request->taxstatus; // This could be 'taxable' or 'non-taxable'
            $tax_method = $request->taxmethod; // This could be 'exclusive' or 'inclusive'

            // Default final price is product price
            $finalPrice = $product_price;

            if ($tax_status === 'taxable') {
                if ($tax_method === 'exclusive') {
                    $finalPrice = $product_price + ($product_price * $tax / 100);
                } elseif ($tax_method === 'inclusive') {
                    $finalPrice = $product_price; // Already includes tax
                }
            }


            // Store product
            $data = [
                'name' => $request->name,
                'product_code' => $request->pcode,
                'barcode' => $request->barcode,
                'brand_id' => $request->brand,
                'product_unit' => $request->punit,
                'cost' => $request->cost,
                'product_price' => $request->pprice,
                'final_price' => $finalPrice,
                'qty' => $request->qty,
                'tax' => $request->tax,
                'tax_method' => $request->taxmethod,
                'tax_status' => $request->taxstatus,
                'tax_class' => $request->taxclass,
                'product_type' => $request->ptype,
                'description' => $request->productDetails,
                'image_url' => $image_url,
                'status' => $status, // ← here
                'created_by' => Auth::user()->id,
            ];

            $Product = Product::create($data);

            if ($request->has('categories')) {
                $Product->categories()->sync($request->categories); // saves pivot data
            }
            // Save image
            if ($Product && $request->file('image') != null) {
                $path = public_path() . '/uploads/products/' . $image_url;
                if (file_exists($path)) {
                    unlink($path);
                }
                $request['image']->move(public_path('uploads/products'), $image_url);
            }

            // ✅ Save product variants if type is 'variable'
            if ($Product && $request->ptype === 'variable') {
                if ($request->has('tname') && $request->has('tprice')) {
                    foreach ($request->tname as $index => $variantName) {
                        $variantPrice = $request->tprice[$index] ?? 0;

                        $variantFinalPrice = $variantPrice;
                        if ($request->taxstatus === 'taxable') {
                            if ($request->taxmethod === 'exclusive') {
                                $variantFinalPrice = $variantPrice + ($variantPrice * $request->tax / 100);
                            }
                        }

                        ProductVariant::create([
                            'product_id'   => $Product->id,
                            'variant_name' => $variantName,
                            'variant_price' => $variantPrice,
                            'final_price'  => $variantFinalPrice,
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'url' => route('products.index')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $th->getMessage()
            ]);
        }
    }


    public function show(string $id)
    {
        $data = Product::with(['brand', 'variants', 'createdBy', 'updatedBy', 'deletedBy'])->find($id);
        $settings = Settings::latest()->first();

        if (!$data) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $image = $data->image_url ? 'uploads/products/' . $data->image_url : 'uploads/cutlery.png';

        $html = '<div class="container px-3 py-2">';
        $html .= '<div class="text-center mb-3">';
        $html .= '<img src="' . URL::asset($image) . '" alt="Product Image" height="120" class="img-thumbnail">';
        $html .= '<h4 class="mt-2 fw-bold">' . $data->name . '</h4>';
        $html .= '<p class="text-muted">' . $data->description . '</p>';
        $html .= '</div>';

        $html .= '<table class="table table-bordered table-striped table-sm">';

        $html .= '<tr><th>Product Code</th><td>' . $data->product_code . '</td></tr>';
        $html .= '<tr><th>Barcode</th><td>' . $data->barcode . '</td></tr>';
        $html .= '<tr><th>Categories</th><td>';
        if ($data->categories->count()) {
            $html .= '<ul class="mb-0 ps-3">';
            foreach ($data->categories as $category) {
                $html .= '<li>' . e($category->name) . '</li>';
            }
            $html .= '</ul>';
        } else {
            $html .= '<span class="text-muted">No categories assigned</span>';
        }
        $html .= '</td></tr>';

        $html .= '<tr><th>Brand</th><td>' . optional($data->brand)->name . '</td></tr>';
        $html .= '<tr><th>Product Unit</th><td>' . $data->product_unit . '</td></tr>';
        $html .= '<tr><th>Cost Price</th><td>LKR ' . number_format($data->cost, 2) . '</td></tr>';
        $html .= '<tr><th>Selling Price</th><td>LKR ' . number_format($data->product_price, 2) . '</td></tr>';
        $html .= '<tr><th>Final Price (Incl. Tax)</th><td class="fw-bold text-success">LKR ' . number_format($data->final_price, 2) . '</td></tr>';
        $html .= '<tr><th>Available Quantity</th><td>' . $data->qty . '</td></tr>';

        $html .= '<tr><th>Tax (%)</th><td>' . $data->tax . '%</td></tr>';
        $html .= '<tr><th>Tax Method</th><td>' . ucfirst($data->tax_method) . '</td></tr>';
        $html .= '<tr><th>Tax Status</th><td>' . ucfirst($data->tax_status) . '</td></tr>';
        $html .= '<tr><th>Tax Class</th><td>' . $data->tax_class . '</td></tr>';

        $html .= '<tr><th>Product Type</th><td>' . ucfirst($data->product_type) . '</td></tr>';
        $html .= '<tr><th>Visibility</th><td>' . ucfirst($data->status) . '</td></tr>';

        if ($data->product_type === 'variable' && $data->variants->count()) {
            $html .= '<tr><th>Variants</th><td>';
            $html .= '<ul class="mb-0">';
            foreach ($data->variants as $variant) {
                $html .= '<li>' . $variant->variant_name . ' - LKR ' . number_format($variant->final_price, 2) . '</li>';
            }
            $html .= '</ul></td></tr>';
        }

        $html .= '<tr><th>Created By</th><td>' . optional($data->createdBy)->name . '</td></tr>';
        $html .= '<tr><th>Updated By</th><td>' . optional($data->updatedBy)->name . '</td></tr>';
        $html .= '<tr><th>Deleted By</th><td>' . optional($data->deletedBy)->name . '</td></tr>';

        $html .= '<tr><th>Created At</th><td>' . date_format(new DateTime($data->created_at), $settings->date_format) . '</td></tr>';
        $html .= '</table>';
        $html .= '</div>';

        return response()->json([$html]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Products';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('products.index'), 'active' => false],
            ['label' => 'Edit', 'url' => '', 'active' => true],
        ];

        $data = Product::find($id);
        $ing_array = [];
        $ing_ids = [];
        $total = 0;


        $is_edit = true;
        $ingredients = Brand::all();
        $categories = Category::all();
        $unit = Unit::all();
        $total = number_format($total, 2);

        $pvdata = Product::with('variants')->findOrFail($id);

        $data->category_ids = $data->categories->pluck('id')->toArray();


        return view('pos.products.create-edit', compact(
            'title',
            'breadcrumbs',
            'is_edit',
            'data',
            'ingredients',
            'categories',
            'ing_array',
            'total',
            'unit',
            'pvdata'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

         dd($request->all());
        $tableData = json_decode($request->input('table_data'), true);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products,name,' . $id . ',id',
            'pcode' => 'required',
            'barcode' => 'required',
            'brand' => 'required',
            'punit' => 'required',
            'cost' => 'required',
            'pprice' => 'required',
            'qty' => 'required',
            'tax' => 'required',
            'taxmethod' => 'required',
            'taxstatus' => 'required',
            'taxclass' => 'required',
            'ptype' => 'required',
            'productDetails' => 'required',
            'image' => 'nullable|max:5000',
            'force_error' => 'required',
        ]);

      if ($validator->fails()) {
    $errors = $validator->errors()->all();
    Log::error('Validation failed', $errors);
    return response()->json([
        'success' => false,
        'errors' => $errors
    ], 422);
}

        if ($request->file('image') != null) {
            $preferred_name = trim($request->name);
            $image_url = $preferred_name . '.' . $request['image']->extension();
        }

        try {

            $status = $request->has('status') ? 'private' : 'public';
            $product_price = $request->pprice;
            $tax = $request->tax;
            $tax_status = $request->taxstatus; // This could be 'taxable' or 'non-taxable'
            $tax_method = $request->taxmethod; // This could be 'exclusive' or 'inclusive'

            // Default final price is product price
            $finalPrice = $product_price;

            if ($tax_status === 'taxable') {
                if ($tax_method === 'exclusive') {
                    $finalPrice = $product_price + ($product_price * $tax / 100);
                } elseif ($tax_method === 'inclusive') {
                    $finalPrice = $product_price; // Already includes tax
                }
            }

            $data = [
                'name' => $request->name,
                'product_code' => $request->pcode,
                'barcode' => $request->barcode,
                'brand_id' => $request->brand,
                'product_unit' => $request->punit,
                'cost' => $request->cost,
                'product_price' => $request->pprice,
                'final_price' => $finalPrice,
                'qty' => $request->qty,
                'tax' => $request->tax,
                'tax_method' => $request->taxmethod,
                'tax_status' => $request->taxstatus,
                'tax_class' => $request->taxclass,
                'product_type' => $request->ptype,
                'description' => $request->productDetails,
                'status' => $status,
                'updated_by' => Auth::user()->id,
            ];

            if ($request->file('image') != null) {
                $preferred_name = trim($request->name);
                $image_url = $preferred_name . '.' . $request['image']->extension();
                $data['image_url'] = $image_url;
            }

            $product = Product::find($id);
            $product->update($data);

            if ($request->has('categories')) {
                $product->categories()->sync($request->categories);
            }
            // Handle image upload
            if ($request->file('image') != null) {
                $path = public_path('uploads/products/' . $image_url);
                if (file_exists($path)) {
                    unlink($path);
                }
                $request['image']->move(public_path('uploads/products'), $image_url);
            }

            // --- Variants Update ---

            // Delete existing variants
            ProductVariant::where('product_id', $product->id)->delete();

            // Insert new variants if product type is 'variable'
            if ($request->ptype === 'variable') {
                if ($request->has('tname') && $request->has('tprice')) {


                    foreach ($request->tname as $index => $variantName) {
                        $variantPrice = $request->tprice[$index] ?? 0;

                        $variantFinalPrice = $variantPrice;
                        if ($request->taxstatus === 'taxable') {
                            if ($request->taxmethod === 'exclusive') {
                                $variantFinalPrice = $variantPrice + ($variantPrice * $request->tax / 100);
                            }
                        }

                        ProductVariant::create([
                            'product_id'   => $product->id,
                            'variant_name' => $variantName,
                            'variant_price' => $variantPrice,
                            'final_price'  => $variantFinalPrice,
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Product updated',
                'url' => route('products.index')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $Product = Product::find($id);
            $Product->update(['deleted_by' => Auth::user()->id]);
            $Product->delete();
            $ProductIngredients = ProductsIngredients::where('product_id', $id)->get();
            $ProductIngredients->each->delete();

            return json_encode(['success' => true, 'message' => 'Product deleted', 'url' => route('products.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Get Product Details
     */

    public function getVariants($productId)
    {
        $product = Product::with('variants:id,product_id,variant_name')->findOrFail($productId);

        return response()->json([
            'variants' => $product->variants,
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->get('q');

        $items = \App\Models\Inventory::with(['product.categories', 'variant'])
            ->whereHas('product', function ($q) use ($term) {
                $q->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('product_price', 'LIKE', "%{$term}%");
            })
            ->orWhereHas('variant', function ($q) use ($term) {
                $q->where('variant_name', 'LIKE', "%{$term}%");
            })
            ->orWhereHas('product.categories', function ($q) use ($term) {
                $q->where('name', 'LIKE', "%{$term}%");
            })
            ->where('quantity', '>', 0)
            ->get()
            ->map(function ($item) {
                $obj = (object) $item->toArray();
                $vid = null;
                $name = $item->product ? $item->product->name : 'Unknown Product';
                if ($item->variant) {
                    $name .= ' - ' . $item->variant->variant_name;
                    $vid = $item->variant->id;
                }
                $obj->full_name = $name;
                $obj->pname = $item->product ? $item->product->id : null;
                $obj->varientid = $vid;
                $obj->categories = $item->product ? $item->product->categories : collect();
                $obj->product_image_url = $item->product && $item->product->image_url
                    ? 'uploads/products/' . $item->product->image_url
                    : 'uploads/cutlery.png';
                $obj->unit_price = $item->product ? $item->product->product_price : 0;

                return $obj;
            });

        return response()->json(
            $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'full_name' => $item->full_name,
                    'pname' => $item->pname,
                    'varientid' => $item->varientid,
                    'categories' => $item->categories->pluck('name')->implode(', '),
                    'unit_price' => number_format($item->unit_price, 2),
                    'product_image_url' => URL::asset($item->product_image_url),
                ];
            })
        );
    }



    public function getProducts(Request $request)
    {
        $prodId = $request['prod_id'];

        $product = Product::where('id', $prodId)->first();
        $settings = Settings::latest()->first();

        $col = '<tr>';
        $col .= '<td><span class="iname">' . $product->name . '</span></td>';
        $col .= '<td><input type="number" step="any" class="form-control bg-transparent" id="quantity" name="quantity[]"></td>';
        // $col .= '<td>' .$product->ingredients->quantity. '</span></td>';
        $col .= '<td><button class="btn bg-transparent border-0 text-danger remove_row"><i class="ri-delete-bin-2-line"></i></button></td>';
        $col .= '<td><input type="hidden" step="any" class="form-control bg-transparent prod_id" value="' . $prodId . '" name="prod_id[]"></td>';
        $col .= '</tr>';

        return response()->json(['col' => $col]);
    }

    /**
     * Get Meal Product Details
     */
    public function getMealProducts(Request $request)
    {
        $id = $request['id'];
        $meal = Meal::find($id);
        $html = '<table class="table" cellspacing="0" cellpadding="0">';
        $html .= '<tr>';
        $html .= '<th>Product Name</th>';
        $html .= '<th>Consumed Quantity</th>';
        $html .= '</tr>';

        foreach ($meal->products as $prod) {
            $consumed = MealsProducts::where('meal_id', $id)->where('product_id', $prod->id)->first();

            $html .= '<tr>';
            $html .= '<td>' . $prod->name . '</td>';
            $html .= '<td>' . $consumed->quantity . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';

        return response()->json([$html]);
    }
    public function productReport()
    {
        $title = 'Prodcut Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Product::with('category')->get();
        return view('reports.productReports', compact('data'));
    }
}
