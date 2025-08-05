<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Facades\URL;


class BrandController extends Controller
{
     public function index() {
        $title = 'Brand';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Brand::all();
     return view('pos.brand.index', compact('title', 'breadcrumbs', 'data'));
    }

  
    public function create() {
        $title = 'Brand';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('brand.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $is_edit = false;

     return view('pos.brand.create-edit', compact('title', 'breadcrumbs', 'is_edit'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:brands,name',
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
                'created_by' => Auth::user()->id,
            ];

            $Category = Brand::create($data);

            if ($Category != null) {
                if ($request->file('image') != null) {
                    $preferred_name = trim($request->name);
                    $path = public_path() . '/uploads/categories/' . $preferred_name . '.' . $request['image']->extension();
                    if (file_exists($path)) {
                        unlink($path);
                    }

                    $request['image']->move(public_path('uploads/categories'), $image_url);
                }
            }

            return json_encode(['success' => true, 'message' => 'Brand created', 'url' => route('brand.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }

  public function show(string $id) {
        $data = Brand::find($id);

        $settings = Settings::latest()->first();

        if($data->image_url != null){
            $image = 'uploads/categories/'.$data->image_url;
        }else{
            $image = 'uploads/cutlery.png';
        }

        $html = '<table class="table" cellspacing="0" cellpadding="0">';
     
        $html .= '<tr>';
        $html .= '<td>Name :</td>';
        $html .= '<td>' . $data->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
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
    public function edit(string $id) {
        $title = 'Brand';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('brand.index'), 'active' => false],
            ['label' => 'Edit', 'url' => '', 'active' => true],
        ];

        $is_edit = true;
        $data = Brand::find($id);

     return view('pos.brand.create-edit', compact('title', 'breadcrumbs', 'is_edit', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:15|unique:brands,name,' . $id,
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

        if($request->file('image') != null) {
            $preferred_name = trim($request->name);
            $image_url = $preferred_name . '.' . $request['image']->extension();
        }

        try {
            $data = [
                'name' => $request->name,
                'updated_by' => Auth::user()->id,
            ];

            if($request->file('image') != null) {
                $data['image_url'] = $image_url;
            }

            $Category = Brand::find($id)->update($data);

            if($Category != null){
                if($request->file('image') != null) {
                    $preferred_name = trim($request->name);
                    $path = public_path() . '/uploads/categories/' . $preferred_name . '.' . $request['image']->extension();
                    if(file_exists($path)) {
                        unlink($path);
                    }

                    $request['image']->move(public_path('uploads/categories'), $image_url);
                }
            }

            return json_encode(['success' => true, 'message' => 'Brand updated', 'url' => route('brand.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        try {

            $Category = Brand::find($id);
            $Category->update(['deleted_by' => Auth::user()->id]);
            $Category->delete();

            return json_encode(['success' => true, 'message' => 'brand deleted', 'url' => route('brand.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }
}
