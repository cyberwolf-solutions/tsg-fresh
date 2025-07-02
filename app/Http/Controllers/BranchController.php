<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\TenantDatabaseManagers\MySQLDatabaseManager;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Tenant::with('domains')->get();
        Log::info('Branches loaded: ', ['branches' => $branches->toArray()]);
        return view('tenancy.index', ['branches' => $branches]);
    }

    public function create()
    {
        return view('tenancy.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'domain' => 'required|string|unique:domains,domain',
                'contact_email' => 'nullable|email|max:255',
                'contact_phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
            ]);

            // Prepare tenant data
            $tenantData = [
                'name' => $request->name,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
                'address' => $request->address,
            ];
            Log::info('Creating new tenant with data:', $tenantData);

            // Create tenant
            $tenant = Tenant::create([
                'id' => Str::slug($request->name),
                'data' => [
                    'name' => $request->name,
                    'contact_email' => $request->contact_email,
                    'contact_phone' => $request->contact_phone,
                    'address' => $request->address,
                ]
            ]);

            Log::info('Tenant created successfully', ['tenant_id' => $tenant->id]);

            // Create domain
            $domain = $tenant->domains()->create([
                'domain' => $request->domain,
            ]);
            Log::info('Domain created successfully', ['domain' => $domain->domain]);

            // Get the database name
            $databaseName = 'tenant_' . $tenant->id; // Matches config('tenancy.database.prefix') + tenant_id
            Log::info('Expected database name:', ['database_name' => $databaseName]);

            // Explicitly create tenant database
            $databaseManager = app(MySQLDatabaseManager::class);
            try {
                Log::info('Attempting to create tenant database', [
                    'tenant_id' => $tenant->id,
                    'database_name' => $databaseName,
                ]);

                // Set the connection explicitly
                $connectionName = config('tenancy.database.template_tenant_connection', 'tenant_template');
                $databaseManager->setConnection($connectionName);
                Log::info('Database manager connection set', ['connection' => $connectionName]);

                $databaseManager->createDatabase($tenant);

                // Verify database existence
                $databases = DB::connection('mysql')->select("SHOW DATABASES LIKE '$databaseName'");

                if (empty($databases)) {
                    Log::error('Database was not created', ['database_name' => $databaseName]);
                    throw new \Exception('Failed to create tenant database: ' . $databaseName);
                }
                Log::info('Tenant database created successfully', ['database_name' => $databaseName]);
            } catch (\Exception $e) {
                Log::error('Failed to create tenant database', [
                    'tenant_id' => $tenant->id,
                    'database_name' => $databaseName,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                throw $e;
            }

            // Run migrations for the tenant
            $tenant->run(function () use ($tenant, $databaseName) {
                try {
                    Log::info('Initializing tenant context', [
                        'tenant_id' => $tenant->getTenantKey(),
                        'database_name' => $databaseName,
                    ]);

                    // Verify database connection
                    DB::connection('tenant')->getPdo();
                    Log::info('Successfully connected to tenant database', [
                        'tenant_id' => $tenant->getTenantKey(),
                        'database_name' => $databaseName,
                    ]);

                    // Run migrations
                    $result = Artisan::call('tenants:migrate', [
                        '--tenants' => [$tenant->getTenantKey()],
                    ]);

                    // Log migration result
                    $tables = DB::connection('tenant')->select('SHOW TABLES');
                    $tableNames = array_map(function ($table) {
                        return reset($table);
                    }, $tables);

                    Log::info('Tenant migrations executed', [
                        'tenant_id' => $tenant->getTenantKey(),
                        'database_name' => $databaseName,
                        'result' => $result === 0 ? 'Success' : 'Failed',
                        'tables_created' => $tableNames,
                    ]);

                    if ($result !== 0) {
                        throw new \Exception('Migration failed for tenant: ' . $tenant->getTenantKey());
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to migrate tenant database', [
                        'tenant_id' => $tenant->getTenantKey(),
                        'database_name' => $databaseName,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    throw $e;
                }
            });

            return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
        } catch (\Exception $e) {
            Log::error('Error in branch creation process', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create branch: ' . $e->getMessage());
        }
    }
}
