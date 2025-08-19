<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //
    public function index()
    {
        $tenant = tenant();

        if (!$tenant) {
            Log::error('Tenant not found');
            abort(404, 'Tenant not found');
        }

        $branch = $tenant->id;
        $domain = $tenant->domains()->first()?->domain;

        if (!$domain) {
            Log::error('Domain not found for tenant', ['tenant_id' => $tenant->id]);
            abort(404, 'Domain not found for the tenant');
        }

        Log::info('Loading single product view for tenant and product', [
            'branch' => $branch,
            'domain' => $domain,

        ]);

        return view('Landing-page.cart', [
            'tenant' => $tenant,
            'branch' => $branch,
            'domain' => $domain,
        ]);
    }
}
