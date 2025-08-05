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
        $data = Product::all();

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

        return view('pos.products.create-edit', compact('title', 'breadcrumbs', 'is_edit', 'categories', 'ingredients'));
    }



    public function store(Request $request)
    {
        $tableData = json_decode($request->input('table_data'), true);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products,name',
            'category' => 'required',
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
            // Update ingredients stock
            // if ($tableData) {
            //     foreach ($tableData as $data) {
            //         $name = $data['name'];
            //         $quantity = $data['consumption_qty'];

            //         $inventoryItem = Ingredient::where('name', $name)->first();
            //         if ($inventoryItem) {
            //             $inventoryItem->quantity -= $quantity;
            //             $inventoryItem->quantity = max(0, $inventoryItem->quantity);
            //             $inventoryItem->save();
            //         }
            //     }
            // }

            $status = $request->has('status') ? 'private' : 'public';

            // Store product
            $data = [
                'name' => $request->name,
                'category_id' => $request->category,
                'product_code' => $request->pcode,
                'barcode' => $request->barcode,
                'brand_id' => $request->brand,
                'product_unit' => $request->punit,
                'cost' => $request->cost,
                'product_price' => $request->pprice,
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

            // Save image
            if ($Product && $request->file('image') != null) {
                $path = public_path() . '/uploads/products/' . $image_url;
                if (file_exists($path)) {
                    unlink($path);
                }
                $request['image']->move(public_path('uploads/products'), $image_url);
            }

            // Store ingredients
            // if ($Product && isset($request['ing_id']) && count($request['ing_id']) > 0) {
            //     foreach ($request['ing_id'] as $k => $v) {
            //         ProductsIngredients::create([
            //             'product_id' => $Product->id,
            //             'ingredient_id' => $v,
            //             'quantity' => $request['quantity'][$k],
            //             'created_by' => Auth::user()->id,
            //         ]);
            //     }
            // }

            // ✅ Save product variants if type is 'variable'
            if ($Product && $request->ptype === 'variable') {
                if ($request->has('tname') && $request->has('tprice')) {
                    foreach ($request->tname as $index => $variantName) {
                        $variantPrice = $request->tprice[$index] ?? 0;

                        ProductVariant::create([
                            'product_id' => $Product->id,
                            'variant_name' => $variantName,
                            'variant_price' => $variantPrice,
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


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Product::find($id);

        $settings = Settings::latest()->first();

        if ($data->image_url != null) {
            $image = 'uploads/products/' . $data->image_url;
        } else {
            $image = 'uploads/cutlery.png';
        }

        $html = '<table class="table" cellspacing="0" cellpadding="0">';
        $html .= '<tr>';
        $html .= '<td colspan="2"><img style="padding-left: 25%;" src="' . URL::asset($image) . '" alt="" height="100"></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Name :</td>';
        $html .= '<td>' . $data->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Description :</td>';
        $html .= '<td>' . $data->description . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Unit Price :</td>';
        $html .= '<td>LKR.' . number_format($data->unit_price_lkr, 2) . '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Unit Price :</td>';
        $html .= '<td>USD.' . number_format($data->unit_price_usd, 2) . '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Unit Price :</td>';
        $html .= '<td>EURO.' . number_format($data->unit_price_eu, 2) . '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Category :</td>';
        $html .= '<td>' . @$data->category->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Type :</td>';
        $html .= '<td>' . $data->type . '</td>';
        $html .= '</tr>';
        if (isset($data->ingredients)) {
            $html .= '<tr>';
            $html .= '<td>Ingredients :</td>';
            $html .= '<td><a href="javascript:void();" data-url="' . route('get-product-ingredients') . '" data-id="' . $data->id . '"
                class="show-ingredients">Show Ingredients</a></td>';
            $html .= '</tr>';
        }
        $html .= '<tr>';
        $html .= '<td>Created By :</td>';
        $html .= '<td>' . $data->createdBy->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Created Date :</td>';
        $html .= '<td>' . date_format(new DateTime('@' . strtotime($data->created_at)), $settings->date_format) . '</td>';
        $html .= '</tr>';
        $html .= '</table>';

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

        if (isset($data->ingredients)) {
            foreach ($data->ingredients as $k => $ingd) {
                $consumed = ProductsIngredients::where('product_id', $id)->where('ingredient_id', $ingd->id)->first();
                $settings = Settings::latest()->first();
                $unit_price = str_replace(',', '', $ingd->unit_price);
                $unit_price = (float)$unit_price;
                // $unit_price = number_format($ingd->unit_price, 2);

                $cost = number_format(($unit_price * ($consumed->quantity)), 2);


                $ing_array[$k] = [
                    'id' => $ingd->id,
                    'name' => $ingd->name,
                    'avl_qty' => $ingd->quantity,
                    'unit' => $ingd->unit->name,
                    'currency' => $settings->currency,
                    'unit_price' => $unit_price,
                    'cost' => $cost,
                    'cons_qty' => $consumed->quantity
                ];
                $total += ($unit_price * ($consumed->quantity));
                array_push($ing_ids, $ingd->id);
            }
        }

        $is_edit = true;
        $ingredients = Ingredient::whereNotIn('id', $ing_ids)->get();
        $categories = Category::all();
        $total = number_format($total, 2);

        return view('pos.products.create-edit', compact(
            'title',
            'breadcrumbs',
            'is_edit',
            'data',
            'ingredients',
            'categories',
            'ing_array',
            'total'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $tableData = json_decode($request->input('table_data'), true);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products,name,' . $id,
            'category' => 'required',
            'unit_price' => 'required',
            'unit_price_usd' => 'required',
            'unit_price_eu' => 'required',
            'type' => 'required',
            'description' => 'nullable',
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

        if ($request->file('image') != null) {
            $preferred_name = trim($request->name);
            $image_url = $preferred_name . '.' . $request['image']->extension();
        }

        try {


            if ($tableData) {
                foreach ($tableData as $data) {
                    $name = $data['name'];
                    $quantity = $data['consumption_qty'];

                    $inventoryItem = Ingredient::where('name', $name)->first();

                    if ($inventoryItem) {

                        $inventoryItem->quantity -= $quantity;


                        if ($inventoryItem->quantity < 0) {
                            $inventoryItem->quantity = 0;
                        }


                        $inventoryItem->save();
                    }
                }
            }




            $data = [
                'name' => $request->name,
                'category_id' => $request->category,
                'unit_price_lkr' => $request->unit_price,
                'unit_price_usd' => $request->unit_price_usd,
                'unit_price_eu' => $request->unit_price_eu,
                'type' => $request->type,
                'description' => $request->description,
                'updated_by' => Auth::user()->id,
            ];

            if ($request->file('image') != null) {
                $data['image_url'] = $image_url;
            }

            $product = Product::find($id)->update($data);
            $Product = Product::find($id);

            if ($Product != null) {
                if (isset($request['ing_id']) && count($request['ing_id']) > 0) {
                    $deleted = ProductsIngredients::where('product_id', $Product->id)->get();
                    $deleted->each->delete();
                    foreach ($request['ing_id'] as $k => $v) {
                        ProductsIngredients::create([
                            'product_id' => $Product->id,
                            'ingredient_id' => $v,
                            'quantity'  => $request['quantity'][$k],
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                }

                if ($request->file('image') != null) {
                    $preferred_name = trim($request->name);
                    $path = public_path() . '/uploads/products/' . $preferred_name . '.' . $request['image']->extension();
                    if (file_exists($path)) {
                        unlink($path);
                    }

                    $request['image']->move(public_path('uploads/products'), $image_url);
                }
            }

            return json_encode(['success' => true, 'message' => 'Product updated', 'url' => route('products.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
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
