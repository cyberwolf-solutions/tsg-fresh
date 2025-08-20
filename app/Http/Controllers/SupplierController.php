<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Supplier;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Suppliers';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Supplier::all();
        return view('pos.suppliers.index', compact('title', 'breadcrumbs', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Suppliers';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('users.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $is_edit = false;

        return view('pos.suppliers.create-edit', compact('title', 'breadcrumbs', 'is_edit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:suppliers,name',
            'contact' => 'required|string|max:15', // Assuming a maximum length of 15 characters for a phone number
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'companyname' => 'required|string',
            'vat' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal' => 'required|string',
            'country' => 'required|string',
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
        } else {
            $image_url = null;
        }

        try {
            $data = [
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'address' => $request->address,
                'image_url' => $image_url,
                'company_name' => $request->companyname,
                'vat' => $request->vat,
                'city' => $request->city,
                'state' => $request->state,
                'postalcode' => $request->postal,
                'country' => $request->country,

                'created_by' => Auth::user()->id,
            ];

            $supplier = Supplier::create($data);

            return json_encode(['success' => true, 'message' => 'Supplier created', 'url' => route('suppliers.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Supplier::find($id);

        $settings = Settings::latest()->first();

        // Check if the data is not found
        if (!$data) {
            return response()->json(['message' => 'Transfer not found.']);
        }
        // dd($data->name);
        $html = '<table class="table">';
        $html .= '<tr>';
        $html .= '<td>Name :</td>';
        $html .= '<td>' . $data->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Contact Primary :</td>';
        $html .= '<td>' . $data->contact . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Contact Secondary :</td>';
        $html .= '<td>' . $data->company_name ?? '-' . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Email :</td>';
        $html .= '<td>' . $data->email ?? '-' . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Address :</td>';
        $html .= '<td>' . $data->address . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>postalcode :</td>';
        $html .= '<td>' . $data->postalcode . '</td>';
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
        $title = 'Suppliers';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('users.index'), 'active' => false],
            ['label' => 'Edit', 'url' => '', 'active' => true],
        ];

        $is_edit = true;

        $data = Supplier::find($id);

        return view('pos.suppliers.create-edit', compact('title', 'breadcrumbs', 'is_edit', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:suppliers,name',
            'contact' => 'required|string|max:15', // Assuming a maximum length of 15 characters for a phone number
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'companyname' => 'required|string',
            'vat' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal' => 'required|string',
            'country' => 'required|string',
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
        } else {
            $image_url = null;
        }

        try {
            $data = [
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'address' => $request->address,
                'image_url' => $image_url,
                'company_name' => $request->companyname,
                'vat' => $request->vat,
                'city' => $request->city,
                'state' => $request->state,
                'postalcode' => $request->postal,
                'country' => $request->country,
                'updated_by' => Auth::user()->id,
            ];


            $Supplier = Supplier::find($id)->update($data);

            return json_encode(['success' => true, 'message' => 'Supplier updated', 'url' => route('suppliers.index')]);
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

            $Supplier = Supplier::find($id);
            $Supplier->update(['deleted_by' => Auth::user()->id]);
            $Supplier->delete();

            return json_encode(['success' => true, 'message' => 'Supplier deleted', 'url' => route('suppliers.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function suppliersReport()
    {
        $title = 'Suppliers Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Supplier::all();

        return view('reports.spplierReports', compact('data'));
    }
}
