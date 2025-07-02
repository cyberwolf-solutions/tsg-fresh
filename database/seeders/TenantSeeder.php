<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Database\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain;

class TenantSeeder extends Seeder
{
    public function run()
    {
        Log::channel('tenant')->info('Starting tenant seeding process');

        try {
            // Create local development tenant
            $tenant = Tenant::create([
                'id' => 'local',
                'data' => [
                    'name' => 'Local Development',
                    'contact_email' => 'dev@example.com',
                    'contact_phone' => '1234567890',
                    'address' => '123 Developer Street',
                ]
            ]);

            Log::channel('tenant')->info('Main tenant created', [
                'tenant_id' => $tenant->id,
                'tenant_data' => $tenant->data
            ]);

            // Create domain for local development
            $domain = $tenant->domains()->create([
                'domain' => '127.0.0.1',
            ]);

            Log::channel('tenant')->info('Domain created for main tenant', [
                'domain_id' => $domain->id,
                'domain' => $domain->domain
            ]);

            // Create additional test tenants
            $this->createTestTenant('Acme Corp', 'acme.test', 'contact@acme.com', '555-1234', '123 Business Ave');
            $this->createTestTenant('Example Inc', 'example.test', 'info@example.com', '555-5678', '456 Corporate Blvd');

            Log::channel('tenant')->info('All tenants and domains seeded successfully');
        } catch (\Exception $e) {
            Log::channel('tenant')->error('Tenant seeding failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-throw to ensure the seeder fails visibly
        }
    }

    protected function createTestTenant($name, $domain, $email, $phone, $address)
    {
        $tenantId = Str::slug($name);

        Log::channel('tenant')->info('Creating test tenant', [
            'name' => $name,
            'tenant_id' => $tenantId
        ]);

        $tenant = Tenant::create([
            'id' => $tenantId,
            'data' => [
                'name' => $name,
                'contact_email' => $email,
                'contact_phone' => $phone,
                'address' => $address,
            ]
        ]);

        Log::channel('tenant')->debug('Test tenant created', [
            'tenant_id' => $tenant->id,
            'data' => $tenant->data
        ]);

        $domain = $tenant->domains()->create([
            'domain' => $domain,
        ]);

        Log::channel('tenant')->debug('Domain created for test tenant', [
            'tenant_id' => $tenant->id,
            'domain' => $domain->domain
        ]);

        return $tenant;
    }
}
