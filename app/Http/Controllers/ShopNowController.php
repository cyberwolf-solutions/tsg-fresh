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

        // Get all categories for sidebar (remove pagination for categories)
        $categories = Category::withCount('products')->get(); // Use get() instead of paginate()

        // Base query
        $query = Product::with(['variants', 'categories']);

        // If category_id is passed, filter products
        if ($request->has('category_id') && !empty($request->category_id)) {
            $categoryId = $request->input('category_id');
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        // If search term is provided
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->orWhereHas('categories', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', "%{$searchTerm}%");
                    });
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
