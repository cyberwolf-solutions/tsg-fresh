<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
    public function getDatabaseName()
    {
        $dbName = 'tenant_' . $this->id;
        // Log::info("getDatabaseName() called. Result: $dbName");
        return $dbName;
    }
}
