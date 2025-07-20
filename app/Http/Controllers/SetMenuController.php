<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Product;
use App\Models\SetMenu;
use App\Models\Category;
use App\Models\Settings;
use App\Models\Ingredient;
use App\Models\SetMenuType;
use Illuminate\Http\Request;
use App\Models\SetMenuMealType;
use App\Models\SetmenuProducts;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SetMenuController extends Controller
{
    //
    public function index(){
        $title = "Setmenu";

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = SetMenu::all();
     return view('pos.setmenu.index', compact('title', 'breadcrumbs', 'data'));
    }


    public function create() {
        $title = 'Setmenu Create';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('products.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $is_edit = false;
        $ingredients = Product::all();
        $categories = Category::all();
        $mealtype = SetMenuMealType::all();
        $setmenutype = SetMenuType::all();

     return view('pos.setmenu.create-edit', compact('title', 'breadcrumbs', 'is_edit', 'categories', 'ingredients','mealtype','setmenutype'));
    }


    public function store(Request $request) {


        $tableData = json_decode($request->input('table_data'), true);


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products,name',
            'category' => 'required',
            'setmenu_type' => 'required',
            'setmenu_meal_type' => 'required',

            'unit_price_lkr' => 'required',
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

            // return response()->json(['success' => false, 'message' => $all_errors]);
        }

        if($request->file('image') != null) {
            $preferred_name = trim($request->name);
            $image_url = $preferred_name . '.' . $request['image']->extension();
        }else{
            $image_url = null;
        }

        try {


            if ($tableData) {
                foreach ($tableData as $data) {
                    $name = $data['name'];
                    $quantity = $data['consumption_qty'];

                    // $inventoryItem = Ingredient::where('name', $name)->first();

                    // if ($inventoryItem) {

                    //     $inventoryItem->quantity -= $quantity;


                    //     if ($inventoryItem->quantity < 0) {
                    //         $inventoryItem->quantity = 0;
                    //     }


                    //     $inventoryItem->save();
                    // }
                }
            }



            $data = [
                'name' => $request->name,
                'category_id' => $request->category,
                'unit_price_lkr' => $request->unit_price_lkr,
                'unit_price_usd' => $request->unit_price_usd,
                'unit_price_eu' => $request->unit_price_eu,
                'setmenu_type' => $request->setmenu_type,
                'type' => $request->type,
                // 'setmenu_type' => $request->setmenu_type,
                'setmenu_meal_type' => $request->setmenu_meal_type,
                'description' => $request->description,
                'image_url' => $image_url,
                'created_by' => Auth::user()->id,
            ];

            $setmenu = SetMenu::create($data);

            if($setmenu != null){
                if(isset($request['prod_id']) && count($request['prod_id']) > 0){
                    $deleted = SetmenuProducts::where('setmenu_id',$setmenu->id)->get();
                    $deleted->each->delete();
                    foreach($request['prod_id'] as $k=>$v){
                        SetmenuProducts::create([
                            'setmenu_id' => $setmenu->id,
                            'product_id' => $v,
                            'quantity'  => $request['quantity'][$k],
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                }

                if($request->file('image') != null) {
                    $preferred_name = trim($request->name);
                    $path = public_path() . '/uploads/setmenu/' . $preferred_name . '.' . $request['image']->extension();
                    if(file_exists($path)) {
                        unlink($path);
                    }

                    $request['image']->move(public_path('uploads/setmenu'), $image_url);
                }
            }

            return json_encode(['success' => true, 'message' => 'Setmenu created', 'url' => route('setmenu.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }




    public function destroy(string $id) {
        try {
            $Meal = SetMenu::find($id);
            $Meal->update(['deleted_by' => Auth::user()->id]);
            $Meal->delete();
            $MealsProducts = SetmenuProducts::where('setmenu_id',$id)->get();
            $MealsProducts->each->delete();

            return json_encode(['success' => true, 'message' => 'Setmenu deleted', 'url' => route('setmenu.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }



    public function show(string $id) {
        $data = SetMenu::find($id);

        $settings = Settings::latest()->first();

        if($data->image_url != null){
            $image = 'uploads/setmenu/'.$data->image_url;
        }else{
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
        $html .= '<td>Category :</td>';
        $html .= '<td>' . $data->category->name . '</td>';
        $html .= '</tr>';

        $html .= '<td>Type :</td>';
        $html .= '<td>' . $data->type . '</td>';
        $html .= '</tr>';

        $html .= '<td>Setmenu Type :</td>';
        $html .= '<td>' . $data->setmenutype->name . '</td>';
        $html .= '</tr>';

        $html .= '<td>Setmenu Meal Type :</td>';
        $html .= '<td>' . $data->setmenumealType->name . '</td>';
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
        $html .= '<td>Unit Price :</td>';
        $html .= '<td>EURO.' . number_format($data->unit_price_eu, 2) . '</td>';
        $html .= '</tr>';

       
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


    
}
