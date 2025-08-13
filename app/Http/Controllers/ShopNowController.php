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



    public function product(Request $request)
    {
        $tenant = tenancy()->tenant;

        if (!$tenant) {
            Log::error('No tenant resolved inside product() method', [
                'domain' => request()->getHost(),
                'url' => request()->fullUrl(),
            ]);
        }

        // Get all categories for sidebar
        $categories = Category::withCount('products')->paginate(15);

        // Base query
        $query = Product::with('variants', 'categories');

        // If category_id is passed, filter products
        if ($request->has('category_id')) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->category_id);
            });
        }

        // Paginate results
        $products = $query->paginate(15);

        // For AJAX requests, return the product grid with pagination links
        if ($request->ajax()) {
            return view('Landing-Page.partials.product-grid', compact('products'))->render();
        }

        // For initial page load
        $recentlyViewed = Product::latest()->take(2)->get();
        return view('Landing-Page.dynamic', compact('categories', 'products', 'recentlyViewed'));
    }
}
