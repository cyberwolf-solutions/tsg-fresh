<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ShopNowController extends Controller
{
    //


    public function index($branch)
    {
        Log::info('ShopNowController index method called', [
            'branch' => $branch,
        ]);

        $tenant = Tenant::find($branch);

        if (!$tenant) {
            Log::error('Tenant not found', ['branch' => $branch]);
            abort(404, 'Branch not found');
        }

        $domain = $tenant->domains()->first()?->domain;

        if (!$domain) {
            Log::error('Domain not found for branch', ['branch' => $branch]);
            abort(404, 'Domain not found for the branch');
        }

        // Add port manually
        $url = "http://{$domain}:8000/shop-now";

        Log::info('Redirecting to shopnow.product', [
            'branch' => $branch,
            'domain' => $domain,
            'redirect_url' => $url,
        ]);

        return redirect($url);
    }



    public function product()
    {
        $tenant = tenancy()->tenant;

        Log::info('ShopNowController@product called', [
            'tenant' => $tenant ? $tenant->id : null,
            'domain' => request()->getHost(),
            'url' => request()->fullUrl(),
        ]);

        if (!$tenant) {
            Log::error('No tenant resolved inside product() method', [
                'domain' => request()->getHost(),
                'url' => request()->fullUrl(),
            ]);
        }

        // Get all categories for sidebar
        $categories = Category::withCount('products')->get();

        // Get all products with their variants
        $products = Product::with('variants')->get();

        // Get recently viewed products (you might want to implement this properly later)
        $recentlyViewed = Product::latest()->take(2)->get();

        return view('Landing-Page.dynamic', [
            'categories' => $categories,
            'products' => $products,
            'recentlyViewed' => $recentlyViewed
        ]);
    }
}
