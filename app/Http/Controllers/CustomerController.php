<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Customer;
use App\Models\Settings;
use Cassandra\Custom;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Guests';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Customer::all();
        return view('customers.index', compact('title', 'breadcrumbs', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Guests';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('customers.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $is_edit = false;
        $currencies = Currency::all();

        return view('customers.create-edit', compact('title', 'breadcrumbs', 'is_edit' , 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:customers,name',
            'contact' => 'required|unique:customers,contact',
            'email' => 'nullable|email|unique:customers,email',
            'address' => 'nullable',
            'image' => 'nullable|image|max:5000',
            'p_no' => 'nullable',
            'n_destination' => 'nullable',
            'nationality' => 'nullable',
            'type' => 'required',
            'signature' => 'nullable|string', 

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

            // Move the image upload code outside the loop
            $request['image']->move(public_path('uploads/guests'), $image_url);
        }

        try {
            $data = [
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'address' => $request->address,
                'passport_no'=>$request->p_no,
                'next_destination'=>$request->n_destination,
                'nationality'=>$request->nationality,
                'image_url' => $image_url,
                'currency_id'=>$request->currency, 
                'type'=>$request->type, 
                'created_by' => Auth::user()->id,
                'signature' => $request->signature,
            ];

            $customer = Customer::create($data);

            return json_encode(['success' => true, 'message' => 'Guests created', 'modal' => true,  'url' => route('customers.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Customer::find($id);

        $settings = Settings::latest()->first();

        $html = '<table class="table" cellspacing="0" cellpadding="0">';
        $html .= '<tr>';
        $html .= '<td>Name: </td>';
        $html .= '<td>' . $data->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Contact </td>';
        $html .= '<td>' . $data->contact . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Passport Number </td>';
        $html .= '<td>' . $data->passport_no . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Next Destination </td>';
        $html .= '<td>' . $data->next_destination . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Nationality </td>';
        $html .= '<td>' . $data->nationality . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Email: </td>';
        $html .= '<td>' . $data->email . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Address: </td>';
        $html .= '<td>' . $data->address . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Created By: </td>';
        $html .= '<td>' . $data->createdBy->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Created Date: </td>';
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
        $title = 'Guests';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('customers.index'), 'active' => false],
            ['label' => 'Edit', 'url' => '', 'active' => true],
        ];

        $is_edit = true;
        $data = Customer::find($id);
        $currencies = Currency::all();

        return view('customers.create-edit', compact('title', 'breadcrumbs', 'is_edit', 'data','currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:customers,name,' . $id,
            'contact' => 'required|unique:customers,contact,' . $id,
            'email' => 'nullable|email|unique:customers,email,' . $id,
            'address' => 'nullable',
            'image' => 'nullable|image|max:5000',
            'p_no' => 'nullable',
            'n_destination' => 'nullable',
            'nationality' => 'nullable',
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

        $customer = Customer::findOrFail($id);

        $image_url = $customer->image_url;
        if ($request->file('image') != null) {
            // Delete the old image
            if ($image_url && file_exists(public_path('uploads/guests/' . $image_url))) {
                unlink(public_path('uploads/guests/' . $image_url));
            }
    
            $preferred_name = trim($request->name);
            $image_url = $preferred_name . '.' . $request['image']->extension();
    
            // Move the new image
            $request['image']->move(public_path('uploads/guests'), $image_url);
        }

        try {
            $data = [
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'address' => $request->address,
                'updated_by' => Auth::user()->id,
                'next_destination'=>$request->n_destination,
                'nationality'=>$request->nationality,
                'image_url' => $image_url, 
                'currency_id'=>$request->currency, 
                'created_by' => Auth::user()->id,
            ];

            $customer = Customer::find($id)->update($data);

            return json_encode(['success' => true, 'message' => 'Guests updated', 'url' => route('customers.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $customer = Customer::find($id);
            $customer->update(['deleted_by' => Auth::user()->id]);
            $customer->delete();

            return json_encode(['success' => true, 'message' => 'Guests deleted', 'url' => route('customers.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function customerReport()
    {
        $title = 'Guests Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Customer::all();

        return view('reports.customerReports', compact('data'));
    }
}
