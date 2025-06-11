<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Unit;
use App\Models\Settings;
use App\Models\Inventory;
use App\Models\inventroy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    //
    public function index()
    {
        $title = 'Inventory';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Inventory::all();

        return view('inventory.index', compact('title', 'breadcrumbs', 'data'));
    }

    public function create()
    {
        $title = 'Inventory Create';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('inventory.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $is_edit = false;
        $units = Unit::all();

        return view('inventory.create-edit', compact('title', 'breadcrumbs', 'is_edit', 'units'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:ingredients,name',
            'unit' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
            'min_quantity' => 'required',
            'description' => 'nullable'
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
                'unit_id' => $request->unit,
                'unit_price' => $request->unit_price,
                'quantity' => $request->quantity,
                'min_quantity' => $request->min_quantity,
                'description' => $request->description,
                'created_by' => Auth::user()->id,
            ];

            $ingredient = Inventory::create($data);

            return json_encode(['success' => true, 'message' => 'Inventory created', 'url' => route('inventory.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }

    public function stock()
    {
        $title = 'Inventory Stock';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Inventory::all();

        return view('inventory.stock', compact('title', 'breadcrumbs', 'data'));
    }



    public function show(string $id)
    {
        $data = Inventory::find($id);

        $settings = Settings::latest()->first();

        // dd($data->name);
        $html = '<table class="table">';
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
        $html .= '<td>' . $settings->currency . ' ' . number_format($data->unit_price, 2) . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Unit :</td>';
        $html .= '<td>' . @$data->unit->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Quantity :</td>';
        $html .= '<td>' . $data->quantity . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Alert Quantity :</td>';
        $html .= '<td>' . $data->min_quantity . '</td>';
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // dd($id);
        $title = 'Inventory';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('inventory.index'), 'active' => false],
            ['label' => 'Edit', 'url' => '', 'active' => true],
        ];

        $is_edit = true;

        $units = Unit::all();
        $data = Inventory::find($id);

        return view('inventory.create-edit', compact('title', 'breadcrumbs', 'is_edit', 'data', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:ingredients,name,' . $id,
            'unit' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
            'min_quantity' => 'required',
            'description' => 'nullable'
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
                'unit_id' => $request->unit,
                'unit_price' => $request->unit_price,
                'quantity' => $request->quantity,
                'min_quantity' => $request->min_quantity,
                'description' => $request->description,
                'updated_by' => Auth::user()->id,
            ];

            $ingredient = Inventory::find($id)->update($data);

            return json_encode(['success' => true, 'message' => 'Inventory updated', 'url' => route('inventory.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }







    public function destroy(string $id)
    {
        try {
            $Ingredient = Inventory::find($id);
            $Ingredient->update(['deleted_by' => Auth::user()->id]);
            $Ingredient->delete();

            return json_encode(['success' => true, 'message' => 'Inventory deleted', 'url' => route('inventory.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }
}
