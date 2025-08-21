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
            // Settings + Mode (already in your code)
            $settings = Settings::latest()->first();
            $mode = (Auth::check() && Auth::user()->is_dark) ? 'dark' : 'light';

            // Latest Products (in stock)

            $latestProducts = Product::latest()->take(4)->get();

            // Best Selling Products (most sold, in stock)
            // $bestSellingProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            //     ->groupBy('product_id')
            //     ->orderByDesc('total_sold')
            //     ->take(4)
            //     ->with('product')
            //     ->get()
            //     ->pluck('product')
            //     ->filter(function ($product) {
            //         return $product && $product->variants->flatMap->inventory->sum('quantity') > 0;
            //     });

            $bestSellingProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
                ->join('order_items', 'order_items.product_id', '=', 'products.id')
                ->groupBy('products.id')
                ->orderByDesc('total_sold')
                ->take(4)
                ->get();
            // Top Rated (placeholder until ratings are implemented)
            $topRatedProducts = collect();

            // Pass all variables
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
