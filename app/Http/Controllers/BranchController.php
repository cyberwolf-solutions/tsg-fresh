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
        // ----------- global log so you see every attempt -----------
        Log::info("BranchController@store called. Tenant ID: {$request->id}, Domain: {$request->domain}");

        try {
            // 1. Validate incoming data
            $request->validate([
                'id'     => 'required|unique:tenants,id',
                'domain' => 'required|unique:domains,domain',
            ]);

            // 2. Create tenant & domain
            $tenant = Tenant::create(['id' => $request->id]);
            $tenant->domains()->create(['domain' => $request->domain]);
            Log::info("Tenant {$tenant->id} created with domain {$request->domain}");

            // 3. Create tenant DB
            CreateDatabase::dispatchSync($tenant);
            Log::info("Database created for tenant {$tenant->id}");

            // 4. Point the tenant connection at the new DB
            config(['database.connections.tenant.database' => $tenant->getDatabaseName()]);

            // 5. Initialise tenancy & confirm DB
            tenancy()->initialize($tenant);
            $tenantDb = DB::connection('tenant')->getDatabaseName();
            Log::info("Tenancy initialised for {$tenant->id}. DB in use: {$tenantDb}");

            // 6. Run tenant‑specific migrations
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path'     => '/database/migrations/tenant',
                '--force'    => true,
            ]);
            Log::info("Migrations finished for tenant {$tenant->id}");

            // 7. Optionally inspect DB context
            $tenant->run(function () {
                Log::info('Inside tenant context for ' . tenant('id')
                    . ' | current DB: ' . DB::connection()->getDatabaseName());
            });

            $tenant->run(function () use ($tenant) {
                Log::info('Running seeders for tenant: ' . tenant('id') . ' on database: ' . DB::connection()->getDatabaseName());
                // Call the seeder directly
                \Illuminate\Support\Facades\Artisan::call('db:seed', [
                    '--database' => 'tenant',
                    '--class' => 'Database\\Seeders\\TenantDatabaseSeeder',
                    '--force' => true,
                ]);
            });


            // 8. Close tenancy context
            tenancy()->end();

            return redirect()
                ->back()
                ->with('success', 'Branch created and database initialised!');
        } catch (\Throwable $e) {
            // ---------- catch *any* exception ----------
            Log::error(
                "Tenant setup failed for requested id {$request->id}: {$e->getMessage()}",
                ['trace' => $e->getTraceAsString()]
            );

            // If tenancy was started, make sure it’s ended
            if (tenancy()->initialized) {
                tenancy()->end();
            }

            // Send user-friendly feedback
            return redirect()
                ->back()
                ->with('error', 'Sorry, the branch could not be created. Check logs for details.');
        }
    }
}
