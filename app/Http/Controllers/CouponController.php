<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function index()
    {
        $title = 'Coupon';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Coupon::all();
        return view('pos.coupon.index', compact('title', 'breadcrumbs', 'data'));
    }

    public function create()
    {
        $title = 'Coupon';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('coupon.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $is_edit = false;


        return view('pos.coupon.create-edit', compact('title', 'breadcrumbs', 'is_edit'));
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'        => 'required|string|max:50|unique:coupons,code',
            'type'        => 'required|in:fixed,percentage',
            'value'       => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date|after_or_equal:today',
            'max_uses'    => 'nullable|integer|min:1',
            'active'      => 'required|boolean',
        ]);

        if ($validator->fails()) {
            dd($validator->errors()->toArray()); // 👈 will dump errors so you see why 422
        }

        $coupon = Coupon::create([
            'code'        => $request->code,
            'type'        => $request->type,
            'value'       => $request->value,
            'expiry_date' => $request->expiry_date,
            'max_uses'    => $request->max_uses,
            'used_count'  => 0,
            'active'      => $request->active,
            'created_by'  => Auth::id(),
        ]);
        return json_encode(['success' => true, 'message' => 'Coupon created', 'modal' => true,  'url' => route('coupon.index')]);

        // return redirect()->route('coupon.index')->with('success', 'Coupon created successfully!');
    }



    public function apply(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)
            ->where('active', 1)
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                    ->orWhere('expiry_date', '>=', now());
            })
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon']);
        }

        return response()->json(['success' => true, 'coupon' => $coupon]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        //
    }
}
