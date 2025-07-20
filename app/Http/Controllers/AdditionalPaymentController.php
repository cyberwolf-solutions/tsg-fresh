<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdditionalPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdditionalPaymentController extends Controller
{
    //

    public function index()
    {

        $title = 'Additional Payments';




        $data = AdditionalPayment::all();
        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];


     return view('pos.additionalpayment.index', compact('data', 'title', 'breadcrumbs'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'list' => 'required',

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

            $existingFacility = AdditionalPayment::where('name', $request->name)->first();

            if ($existingFacility) {
                return json_encode(['success' => false, 'message' => 'This category already exists']);
            }


            $data = [
                'name' => $request->name,
                'description' => $request->list,
                'created_by' => Auth::user()->id,
            ];

            $Roomfacility = AdditionalPayment::create($data);

            return json_encode(['success' => true, 'message' => 'Category created', 'url' => route('additional-payments.index')]);
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
                'description' => $request->list,
                'updated_by' => Auth::user()->id,
            ];

            $RoomType = AdditionalPayment::find($id)->update($data);

            return json_encode(['success' => true, 'message' => 'Category updated', 'url' => route('additional-payments.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }


    public function destroy(string $id)
    {
        try {

            $RoomType = AdditionalPayment::find($id);
            $RoomType->update(['deleted_by' => Auth::user()->id]);
            $RoomType->delete();

            return json_encode(['success' => true, 'message' => 'Category deleted', 'url' => route('additional-payments.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

}
