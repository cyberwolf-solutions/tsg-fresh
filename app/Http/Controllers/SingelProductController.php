<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

use App\Models\Category;


use Stancl\Tenancy\Database\Models\Tenant;

class SingelProductController extends Controller
{



    // public function index($productId)
    // {
    //     $tenant = tenant(); // current tenant

    //     if (!$tenant) {
    //         Log::error('Tenant not found');
    //         abort(404, 'Tenant not found');
    //     }

    //     $branch = $tenant->id;
    //     $domain = $tenant->domains()->first()?->domain;

    //     if (!$domain) {
    //         Log::error('Domain not found for tenant', ['tenant_id' => $tenant->id]);
    //         abort(404, 'Domain not found for the tenant');
    //     }


    //     $product = Product::find($productId);

    //     if (!$product) {
    //         Log::error('Product not found', ['product_id' => $productId]);
    //         abort(404, 'Product not found');
    //     }

    //     Log::info('Loading single product view for tenant and product', [
    //         'branch' => $branch,
    //         'domain' => $domain,
    //         'product_id' => $productId,
    //     ]);

    //     return view('Landing-page.singleView', [
    //         'tenant' => $tenant,
    //         'branch' => $branch,
    //         'domain' => $domain,
    //         'product' => $product,
    //     ]);
    // }

    public function index($productId)
{
    $tenant = tenant(); // current tenant

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
$cat= Category::all();
    $product = Product::with([
        'categories',  // all categories
        'brand',       // brand info
        'variants',    // product variants
        'createdBy',   // user who created
        'updatedBy'    // user who updated
    ])->find($productId);

    if (!$product) {
        Log::error('Product not found', ['product_id' => $productId]);
        abort(404, 'Product not found');
    }

    Log::info('Loading single product view for tenant and product', [
        'branch' => $branch,
        'domain' => $domain,
        'product_id' => $productId,
    ]);

    return view('Landing-page.singleView', [
        'tenant' => $tenant,
        'branch' => $branch,
        'domain' => $domain,
        'product' => $product,
        'cat'
    ]);
}

}

