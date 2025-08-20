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
        $categories = Category::withCount('products')->get();

        // Base query
        $query = Product::with(['variants', 'categories']);

        // Category filter
        if ($request->has('category_id') && !empty($request->category_id)) {
            $categoryId = $request->input('category_id');
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        // Price filter
        if ($request->has('min_price') && !empty($request->min_price)) {
            $minPrice = $request->input('min_price');
            $query->where('final_price', '>=', $minPrice);
        }

        // Search filter
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

        // Sorting
        if ($request->has('sort') && !empty($request->sort)) {
            switch ($request->sort) {
                case 'Sort by popularity':
                    // Implement popularity sorting if you have a popularity metric
                    break;
                case 'Sort by average rating':
                    // Implement rating sorting if you have ratings
                    break;
                case 'Sort by latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'Sort by price: low to high':
                    $query->orderBy('final_price', 'asc');
                    break;
                case 'Sort by price: high to low':
                    $query->orderBy('final_price', 'desc');
                    break;
                default:
                    // Default sorting
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            // Default sorting if none specified
            $query->orderBy('created_at', 'desc');
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
