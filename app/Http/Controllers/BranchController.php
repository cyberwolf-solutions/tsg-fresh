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
        // Fetch all tenants with their domains
        $tenants = Tenant::with('domains')->latest()->get();

        return view('admin.branches.index', compact('tenants'));
    }



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

            // 4. Update DB config dynamically
            config(['database.connections.tenant.database' => $dbName]);
            DB::purge('tenant');
            DB::reconnect('tenant');

            // 5. Initialize tenancy and run migrations in tenant context
            $tenant->run(function () use ($tenant) {
                Log::info("Tenancy initialized for {$tenant->id}. Active DB: " . DB::connection('tenant')->getDatabaseName());

                // Run migrations only in tenant context
                Artisan::call('migrate', [
                    '--database' => 'tenant',
                    '--path' => 'database/migrations/tenant', // Ensure this path is correct
                    '--force' => true,
                ]);
                Log::info("Migrations finished for tenant {$tenant->id}");

                // Run seeders
                Artisan::call('db:seed', [
                    '--database' => 'tenant',
                    '--class' => 'Database\\Seeders\\TenantDatabaseSeeder',
                    '--force' => true,
                ]);
            });

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
