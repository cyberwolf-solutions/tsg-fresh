<?php

namespace App\Providers;

use App\Models\Tenant;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

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
    public function boot(): void
    {


        view()->composer('*', function ($view) {
            $settings = Settings::latest()->first();

            if (Auth::user() && Auth::user()->is_dark) {
                $mode = 'dark';
            } else {
                $mode = 'light';
            }

            $view->with(['mode' => $mode, 'settings' => $settings]);
        });
    }
}
