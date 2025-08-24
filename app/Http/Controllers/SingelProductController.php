<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Models\ProductReview;


use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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


        $status = Review::all()->first();

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
        $cat = Category::all();
        $product = Product::with([
            'categories',  // all categories
            'brand',       // brand info
            'variants',    // product variants
            'createdBy',   // user who created
            'updatedBy'    // user who updated
        ])->find($productId);


        $query = Product::with(['variants', 'categories', 'inventory'])
            ->where('status', 'Public')
            ->latest()
            ->take(6)
            ->get();



        if (!$product) {
            Log::error('Product not found', ['product_id' => $productId]);
            abort(404, 'Product not found');
        }

        Log::info('Loading single product view for tenant and product', [
            'branch' => $branch,
            'domain' => $domain,
            'product_id' => $productId,
        ]);

        // Check if logged in WebCustomer has purchased this product
        $canReview = false;

        if (Auth::guard('customer')->check()) {
            $customerId = Auth::guard('customer')->id();

            $hasPurchased = Order::where('web_customer_id', $customerId)
                ->whereHas('items', function ($q) use ($productId) {
                    $q->where('product_id', $productId);
                })
                ->where('status', 'issued')
                ->exists();

            $canReview = $hasPurchased;

            // Log result
            Log::info('Review check for product', [
                'customer_id' => $customerId,
                'product_id'  => $productId,
                'can_review'  => $canReview
            ]);
        }

        $reviews = ProductReview::where('product_id', $productId)
            ->where('status', 'Approved')
            ->orderBy('id', 'desc')
            ->get();



        return view('Landing-page.singleView', [
            'tenant' => $tenant,
            'branch' => $branch,
            'domain' => $domain,
            'product' => $product,
            'cat',
            'query' => $query,
            'status' => $status,
            'canReview'  => $canReview,
            'reviews'    => $reviews,
        ]);
    }
}
