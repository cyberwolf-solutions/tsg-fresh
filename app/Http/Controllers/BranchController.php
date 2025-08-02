<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Stancl\Tenancy\Jobs\CreateDatabase;
use Stancl\Tenancy\Jobs\MigrateDatabase;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Tenant::all();
     return view('admin.branches.index', compact('branches'));
    }
    // public function store(Request $request)
    // {

    //     Log::info('Creating tenant database for tenant: ' . $request->id);
    //     $request->validate([
    //         'id' => 'required|unique:tenants,id',
    //         'domain' => 'required|unique:domains,domain',
    //     ]);

    //     // Step 1: Create the tenant and domain
    //     $tenant = Tenant::create(['id' => $request->id]);
    //     $tenant->domains()->create(['domain' => $request->domain]);

    //     Log::info('Creating tenant database for tenant: ' . $tenant->id);

    //     // Step 2: Create the tenant database
    //     CreateDatabase::dispatchSync($tenant);

    //     // ✅ Step 3: Set the database connection for the tenant manually
    //     config(['database.connections.tenant.database' => $tenant->getDatabaseName()]);

    //     // Step 4: Initialize tenancy
    //     tenancy()->initialize($tenant);

    //     // Step 5: Confirm database name
    //     $tenantDb = DB::connection('tenant')->getDatabaseName();
    //     Log::info('Tenant database after initialization: ' . $tenantDb);

    //     // Step 6: Run migrations
    //     Artisan::call('migrate', [
    //         '--database' => 'tenant',
    //         '--path' => '/database/migrations/tenant',
    //         '--force' => true,
    //     ]);



    //     // Step 7: Log that we're in the tenant DB
    //     $tenant->run(function () {
    //         Log::info('Inside tenant DB: ' . tenant('id') . ', Database: ' . DB::connection()->getDatabaseName());
    //     });

    //     // Log::info('Running seeders for tenant: ' . $tenant->id . ' on database: ' . $tenantDb);
    //     // Artisan::call('tenants:seed', [
    //     //     '--tenants' => [$tenant->id],
    //     //     '--force' => true,
    //     // ]);

    //     // Step 8: End tenancy
    //     tenancy()->end();

    //     return redirect()->back()->with('success', 'Branch created and database initialized!');
    // }


    public function store(Request $request)
    {
        Log::info("BranchController@store called. Tenant ID: {$request->id}, Domain: {$request->domain}");

        try {
            // 1. Validate request
            $request->validate([
                'id'     => 'required|unique:tenants,id',
                'domain' => 'required|unique:domains,domain',
            ]);

            // 2. Create tenant and domain
            $tenant = Tenant::create(['id' => $request->id]);
            $tenant->domains()->create(['domain' => $request->domain]);
            Log::info("Tenant {$tenant->id} created with domain {$request->domain}");

            // 3. Build DB name
            $dbName = $tenant->getDatabaseName();

            // 4. Check if DB already exists
            // if ($this->doesDatabaseExist($dbName)) {
            //     Log::warning("Database $dbName already exists. Skipping creation.");
            // } else {
            //     // 5. Create tenant DB
            //     CreateDatabase::dispatchSync($tenant);
            //     Log::info("Database $dbName created for tenant {$tenant->id}");
            // }

            // 6. Update DB config dynamically
            config(['database.connections.tenant.database' => $dbName]);
            DB::purge('tenant');
            DB::reconnect('tenant');

            // 7. Initialize tenancy
            tenancy()->initialize($tenant);
            Log::info("Tenancy initialized for {$tenant->id}. Active DB: " . DB::connection('tenant')->getDatabaseName());

            // 8. Run tenant migrations
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path'     => '/database/migrations/tenant',
                '--force'    => true,
            ]);
            Log::info("Migrations finished for tenant {$tenant->id}");

            // 9. Log DB context and run seeders
            $tenant->run(function () {
                Log::info('Inside tenant context for ' . tenant('id') . ' | current DB: ' . DB::connection('tenant')->getDatabaseName());
            });


            $tenant->run(function () {
                DB::setDefaultConnection('tenant');

                $dbName = DB::getDatabaseName();
                Log::info("Inside tenant context for " . tenant('id') . " | current DB: $dbName");

                Artisan::call('db:seed', [
                    '--database' => 'tenant',
                    '--class'    => 'Database\\Seeders\\TenantDatabaseSeeder',
                    '--force'    => true,
                ]);
            });



            // 10. End tenancy
            tenancy()->end();

            return redirect()
                ->back()
                ->with('success', 'Branch created and database initialized!');
        } catch (\Throwable $e) {
            Log::error("Tenant setup failed for {$request->id}: {$e->getMessage()}", [
                'trace' => $e->getTraceAsString()
            ]);

            if (tenancy()->initialized) {
                tenancy()->end();
            }

            return redirect()
                ->back()
                ->with('error', 'Sorry, the branch could not be created. Check logs for details.');
        }
    }

    protected function doesDatabaseExist(string $dbName): bool
    {
        $result = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$dbName]);
        return count($result) > 0;
    }
}
