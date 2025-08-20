<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    //
    public function index()
    {
        $webCustomer = Auth::guard('customer')->user();

        // 1. Get all tenants (assuming you have a tenants table with 'db_name' column)
        $tenants = DB::connection('central')->table('tenants')->get();

        $allOrders = collect();

        foreach ($tenants as $tenant) {
            try {
                // 2. Dynamically set the tenant DB for this query
                $orders = DB::connection('tenant') // tenant connection in config
                    ->setDatabaseName($tenant->db_name) // this requires you to dynamically change the database
                    ->table('orders')
                    ->where('web_customer_id', $webCustomer->id)
                    ->whereNull('deleted_at')
                    ->orderBy('order_date', 'desc')
                    ->get();

                // 3. Add tenant info to each order (optional)
                foreach ($orders as $order) {
                    $order->tenant_name = $tenant->name ?? $tenant->db_name;
                }

                $allOrders = $allOrders->merge($orders);
            } catch (\Exception $e) {
                // skip tenant if DB doesn't exist or connection fails
                continue;
            }
        }

        return view('customer.order', [
            'orders' => $allOrders->sortByDesc('order_date'),
            'webCustomer' => $webCustomer
        ]);
    }
}
