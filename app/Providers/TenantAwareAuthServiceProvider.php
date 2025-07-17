<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Tenancy;

class TenantAwareAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::provider('tenant-aware-eloquent', function ($app, array $config) {
            return new class($app['hash'], $config['model']) extends EloquentUserProvider {
                public function retrieveByCredentials(array $credentials)
                {
                    if (! tenancy()->initialized) {
                        return null;
                    }

                    return parent::retrieveByCredentials($credentials);
                }
            };
        });
    }
}
