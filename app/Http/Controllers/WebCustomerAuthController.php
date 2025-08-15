<?php

namespace App\Http\Controllers;

use App\Models\WebCustomer;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class WebCustomerAuthController extends Controller
{
    //
    public function register(Request $request)
    {

        // Log::info('Customer registration request received', [
        //     'request_data' => $request->all(),
        // ]);
        $request->validate([
            // 'first_name'        => 'required|string|max:255',
            // 'last_name'         => 'required|string|max:255',
            'email'             => 'required|email|unique:customers,email',
            // 'password'          => 'required|string|min:6|confirmed',
            // 'billing_first_name' => 'required|string|max:255',
            // 'billing_last_name' => 'required|string|max:255',
            // 'street_address'    => 'required|string|max:255',
            // 'town'              => 'required|string|max:255',
            // 'phone'             => 'required|string|max:20',
            // 'billing_email'     => 'required|email',
        ]);

        $customer = WebCustomer::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        BillingAddress::create([
            'customer_id'   => $customer->id,
            'first_name'    => $request->billing_first_name,
            'last_name'     => $request->billing_last_name,
            'street_address' => $request->street_address,
            'town'          => $request->town,
            'phone'         => $request->phone,
            'email'         => $request->billing_email,
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('customer')->attempt($request->only('email', 'password'), $request->filled('remember'))) {

            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('Landing-page.shop-now');
    }
}
