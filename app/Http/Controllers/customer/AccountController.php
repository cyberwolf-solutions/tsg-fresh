<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\BillingAddress;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    //
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            dd('No customer logged in!');
        }
        return view('customer.account', compact('customer'));
    }

    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        Log::info('Updating customer account', [
            'customer_id' => $customer->id,
            'request_data' => $request->all(),
        ]);

        // Define validation rules
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'new_password' => 'nullable|min:6|confirmed',
        ];

        // Add current_password validation only if new_password is provided
        if ($request->filled('new_password')) {
            $rules['current_password'] = 'required';
        }

        // Validate the request
        $request->validate($rules);

        // Check current password if new_password is provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $customer->password)) {
                Log::error('Current password mismatch', [
                    'customer_id' => $customer->id,
                ]);
                return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
            }
            $customer->password = Hash::make($request->new_password);
        }

        // Update other fields
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;

        // Save changes only if all validations pass
        $customer->save();

        return back()->with('success', 'Account updated successfully!');
    }

    public function address()
    {
        $customer = Auth::guard('customer')->user();
        $billingAddress = $customer->billingAddress;

        return view('customer.address', compact('billingAddress'));
    }

    // Show create address form
    public function create()
    {
        $customer = Auth::guard('customer')->user();
        $billingAddress = $customer->billingAddress;

        return view('customer.address-create', compact('billingAddress'));
    }

    // Save address
    public function storeAddress(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
        ]);

        // Get existing address or create new
        $billingAddress = $customer->billingAddress ?? new BillingAddress();

        $billingAddress->customer_id = $customer->id;
        $billingAddress->first_name = $request->first_name;
        $billingAddress->last_name = $request->last_name;
        $billingAddress->street_address = $request->street_address;
        $billingAddress->town = $request->town;
        $billingAddress->phone = $request->phone;
        $billingAddress->email = $request->email;

        $billingAddress->save();

        return redirect()->route('customer.address')
            ->with('success', 'Address saved successfully!');
    }
}
