<?php

namespace App\Bootstrappers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant as TenantContract;
use App\Models\Tenant as CustomTenant;

class DatabaseTenancyBootstrapper implements TenancyBootstrapper
{
    public function bootstrap(TenantContract $tenant): void
    {
        /** @var CustomTenant $tenant */
        $dbName = $tenant->getDatabaseName(); // Now calls your custom logic

        Config::set('database.connections.tenant.database', $dbName);
        // Log::info("✅ Custom DatabaseTenancyBootstrapper executed. Tenant DB: $dbName");
    }

    public function revert(): void
    {
        Config::set('database.connections.tenant.database', null);
        // Log::info("⛔️ Custom DatabaseTenancyBootstrapper reverted.");
    }
}
