<?php

namespace App\Http\Controllers;

use App\Models\DeliveryCharge;
use App\Models\Tenant;
use Illuminate\Http\Request;

class DeliveryChargeController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();
        $charges = DeliveryCharge::with('tenant')->get();
        return view('admin.delivery.index', compact('tenants', 'charges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'price_from' => 'required|numeric|min:0',
            'price_to' => 'required|numeric|gt:price_from',
            'charge' => 'required|numeric|min:0',
        ]);

        DeliveryCharge::create($validated);

        return back()->with('success', 'Delivery charge added successfully!');
    }
    public function destroy($id)
    {
        $charge = DeliveryCharge::findOrFail($id);
        $charge->delete();

        return back()->with('success', 'Delivery charge deleted successfully!');
    }
}
