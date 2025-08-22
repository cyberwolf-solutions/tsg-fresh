<?php

namespace App\Providers;

use App\Models\Tenant;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
// use App\Models\Settings;
use App\Models\Product;
use App\Models\OrderItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(TenantWithDatabase::class, function ($app) {
            return $app->make(Tenant::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {


    //     view()->composer('*', function ($view) {
    //         $settings = Settings::latest()->first();

    //         if (Auth::user() && Auth::user()->is_dark) {
    //             $mode = 'dark';
    //         } else {
    //             $mode = 'light';
    //         }

    //         $view->with(['mode' => $mode, 'settings' => $settings]);
    //     });
    // }

    public function boot(): void
    {
        view()->composer('*', function ($view) {
            // Settings + Mode (always from central)
            $settings = Settings::latest()->first();
            $mode = (Auth::check() && Auth::user()->is_dark) ? 'dark' : 'light';

            // Default empty collections
            $latestProducts = collect();
            $bestSellingProducts = collect();
            $topRatedProducts = collect();

            // ✅ Only load tenant products if a tenant is identified
            if (tenant()) {
                // Latest Products
                $latestProducts = Product::latest()->take(4)->get();

                // Best Selling
                $bestSellingProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
                    ->join('order_items', 'order_items.product_id', '=', 'products.id')
                    ->groupBy('products.id')
                    ->orderByDesc('total_sold')
                    ->take(4)
                    ->get();

                // Top Rated (placeholder)
                $topRatedProducts = collect();
            }

            // Pass to all views
            $view->with([
                'mode' => $mode,
                'settings' => $settings,
                'latestProducts' => $latestProducts,
                'bestSellingProducts' => $bestSellingProducts,
                'topRatedProducts' => $topRatedProducts,
            ]);
        });
    }
}
