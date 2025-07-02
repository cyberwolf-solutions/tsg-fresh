<?php

namespace App\Models;

use Carbon\Carbon;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\CentralConnection;
use Stancl\Tenancy\Database\Concerns\GeneratesIds;
use Stancl\Tenancy\Database\Concerns\HasDataColumn;
use Stancl\Tenancy\Database\Concerns\HasInternalKeys;
use Stancl\Tenancy\Database\Concerns\TenantRun;
use Stancl\Tenancy\Database\Concerns\InvalidatesResolverCache;
use Stancl\Tenancy\Database\TenantCollection;
use Stancl\Tenancy\Events;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase,
        HasDomains,
        CentralConnection,
        GeneratesIds,
        HasDataColumn,
        HasInternalKeys,
        TenantRun,
        InvalidatesResolverCache;

    protected static $modelsShouldPreventAccessingMissingAttributes = false;

    protected $table = 'tenants';
    protected $fillable = ['id', 'data'];
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];

    public function getTenantKeyName(): string
    {
        return 'id';
    }

    public function getTenantKey()
    {
        return $this->getAttribute($this->getTenantKeyName());
    }

    public function newCollection(array $models = []): TenantCollection
    {
        return new TenantCollection($models);
    }

    public function domains(): HasMany
    {
        return $this->hasMany(\Stancl\Tenancy\Database\Models\Domain::class, 'tenant_id', 'id');
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }

    protected $dispatchesEvents = [
        'saving' => Events\SavingTenant::class,
        'saved' => Events\TenantSaved::class,
        'creating' => Events\CreatingTenant::class,
        'created' => Events\TenantCreated::class,
        'updating' => Events\UpdatingTenant::class,
        'updated' => Events\TenantUpdated::class,
        'deleting' => Events\DeletingTenant::class,
        'deleted' => Events\TenantDeleted::class,
    ];
}
