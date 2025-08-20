<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankDetailController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();
        $banks = BankDetail::with('tenant')->get();

        return view('admin.bankdetails.index', compact('banks', 'tenants'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'bank_name' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
        ]);

        BankDetail::create($validated);

        return back()->with('success', 'Bank details added successfully!');
    }


    public function destroy($id)
    {
        $bank = BankDetail::findOrFail($id);
        $bank->delete();

        return back()->with('success', 'Bank details deleted successfully!');
    }
}
