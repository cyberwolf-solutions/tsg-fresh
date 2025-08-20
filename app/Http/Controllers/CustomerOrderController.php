<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function index()
    {
        // Get authenticated customer
        $webCustomer = Auth::guard('customer')->user();
        if (!$webCustomer) {
            return redirect()->route('customer.login')->with('error', 'Please login first.');
        }

        // Collection to hold all orders
        $allOrders = collect();

        // Get all tenants from central DB
        $tenants = DB::connection('central')->table('tenants')->get();

        foreach ($tenants as $tenant) {
            $tenantData = json_decode($tenant->data ?? '{}', true);
            $dbName = $tenantData['tenancy_db_name'] ?? null;

            if (!$dbName) continue;

            try {
                // Dynamically set tenant DB
                config(['database.connections.tenant.database' => $dbName]);
                DB::purge('tenant');
                DB::reconnect('tenant');

                $orders = Order::on('tenant')
                    ->where('web_customer_id', $webCustomer->id)
                    ->with(['items.product', 'items.variant'])
                    ->orderBy('order_date', 'desc')
                    ->get();

                foreach ($orders as $order) {
                    $order->tenant_name = $tenant->name ?? $dbName;
                }

                $allOrders = $allOrders->merge($orders);
            } catch (\Exception $e) {
                Log::error('Tenant DB failed: ' . $dbName, ['error' => $e->getMessage()]);
                continue;
            }
        }

        // Sort all orders by order_date descending
        $allOrders = $allOrders->sortByDesc('order_date');

        return view('customer.order', [
            'orders' => $allOrders,
            'webCustomer' => $webCustomer
        ]);
    }
}
