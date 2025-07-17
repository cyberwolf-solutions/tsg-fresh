<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stancl\Tenancy\Tenancy;
use Stancl\Tenancy\Tenant;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-tenant {tenant_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new tenant with a subdomain';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');

        // Create the tenant
        $tenant = Tenancy::create([
            'id' => $tenantId,
        ]);

        // Assign a domain like customer1.tsg.test
        $tenant->domains()->create([
            'domain' => "{$tenantId}.tsg.test",
        ]);

        $this->info("Tenant {$tenantId} created with domain {$tenantId}.tsg.test");
    }
}