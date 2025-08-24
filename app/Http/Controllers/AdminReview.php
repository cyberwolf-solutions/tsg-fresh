<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AdminReview extends Controller
{
    public function index()
    {

        $tenants = Tenant::with('domains')->latest()->get();

        $tenantReviews = [];

        foreach ($tenants as $tenant) {


            $reviews = $tenant->run(function () {
                return ProductReview::with(['product', 'customer'])
                    ->whereHas('product')
                    ->paginate(5);
            });

            $tenantReviews[$tenant->id] = [
                'tenant' => $tenant,
                'reviews' => $reviews
            ];
        }

        return view('admin.review.index', compact('tenants', 'tenantReviews'));
    }





    // Approve a review
    public function approve($tenantId, $reviewId)
    {


        // Fetch tenant
        $tenant = Tenant::findOrFail($tenantId);
        Log::info('Tenant fetched from DB: ' . json_encode($tenant));

        // Get tenant DB name: first try top-level column, then fallback to data JSON
        $tenantDbName = $tenant->tenancy_db_name ?? null;
        if (!$tenantDbName && $tenant->data) {
            $tenantData = json_decode($tenant->data, true);
            $tenantDbName = $tenantData['tenancy_db_name'] ?? null;
            Log::info('Tenant data JSON decoded: ' . json_encode($tenantData));
        }

        if (!$tenantDbName) {
            Log::error('Tenant database not found.');
            return redirect()->back()->with('error', 'Tenant database not found.');
        }



        // Switch tenant connection
        config(['database.connections.tenant.database' => $tenantDbName]);


        // Fetch review
        $review = ProductReview::findOrFail($reviewId);

        // Update status
        $review->status = 'approved';
        $review->save();


        return redirect()->back()->with('success', 'Review approved successfully.');
    }


    public function destroy($tenantId, $reviewId)
    {
        // Fetch tenant
        $tenant = Tenant::findOrFail($tenantId);

        // Get tenant DB name: first try top-level column, then fallback to data JSON
        $tenantDbName = $tenant->tenancy_db_name ?? null;
        if (!$tenantDbName && $tenant->data) {
            $tenantData = json_decode($tenant->data, true);
            $tenantDbName = $tenantData['tenancy_db_name'] ?? null;
        }

        if (!$tenantDbName) {
            return redirect()->back()->with('error', 'Tenant database not found.');
        }

        // Switch tenant connection
        config(['database.connections.tenant.database' => $tenantDbName]);

        // Fetch review
        $review = ProductReview::findOrFail($reviewId);

        // Delete review
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
