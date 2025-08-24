<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'review' => 'required|string|max:1000',
        ]);

        $customerId = Auth::guard('customer')->id();

        $review = ProductReview::create([
            'product_id'  => $product->id,
            'customer_id' => $customerId,
            'review'      => $request->review,
            'status'      => 'Pending',
        ]);

        Log::info('New product review added', [
            'product_id'  => $product->id,
            'customer_id' => $customerId,
            'review_id'   => $review->id,
        ]);

        return redirect()->back()->with('success', 'Thank you for your review! It is pending approval.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(ProductReview $productReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductReview $productReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductReview $productReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductReview $productReview)
    {
        //
    }
}
