<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SetMenuMealType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SetMenuMealController extends Controller
{
    //
    public function index(){


        $title = "Setmenu Meal Category";

        $breadcrumbs = [
            
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        $data = SetMenuMealType::all();

        return view('setmenumeal.index' , compact('breadcrumbs','data','title'));

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            

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

            $existingFacility = SetMenuMealType::where('name', $request->name)->first();

            if ($existingFacility) {
                return json_encode(['success' => false, 'message' => 'This meal type already exists']);
            }


            $data = [
                'name' => $request->name,
            ];

            $Roomfacility = SetMenuMealType::create($data);

            return json_encode(['success' => true, 'message' => 'Setmenu Meal Type created', 'url' => route('setmenumeal.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }


    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            
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
            $data = [
                'name' => $request->name,
                
            ];

            $RoomType = SetMenuMealType::find($id)->update($data);

            return json_encode(['success' => true, 'message' => 'Meal updated', 'url' => route('setmenumeal.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }

    public function destroy(string $id)
    {
        try {

            $RoomType = SetMenuMealType::find($id);
            $RoomType->update(['deleted_by' => Auth::user()->id]);
            $RoomType->delete();

            return json_encode(['success' => true, 'message' => 'Meal deleted', 'url' => route('setmenumeal.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

}
