<?php

declare(strict_types=1);

namespace Stancl\Tenancy\Bootstrappers;

use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Contracts\Tenant;
use Stancl\Tenancy\Database\DatabaseManager;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Exceptions\TenantDatabaseDoesNotExistException;

class DatabaseTenancyBootstrapper implements TenancyBootstrapper
{
    /** @var DatabaseManager */
    protected $database;

    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
        Log::info('DatabaseTenancyBootstrapper instantiated');
    }

    public function bootstrap(Tenant $tenant)
    {
        /** @var TenantWithDatabase $tenant */

        $database = $tenant->database()->getName();
        Log::info("Bootstrapping tenancy for tenant: {$tenant->id}, Database: {$database}");

        // Better debugging, but breaks cached lookup in prod
        if (app()->environment('local')) {
            $database = $tenant->database()->getName();
            if (! $tenant->database()->manager()->databaseExists($database)) {
                throw new TenantDatabaseDoesNotExistException($database);
            }
        }

        $this->database->connectToTenant($tenant);
    }

    public function revert()
    {
        Log::info('Reverting to central database connection');
        $this->database->reconnectToCentral();
    }
}
