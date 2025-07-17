<?php

namespace App\Models;



use Stancl\Tenancy\Database\Models\Tenant;

class Branch extends Tenant
{
    protected $table = 'branches';

    public function getDbNameAttribute(): string
    {
        return 'pos_' . $this->id;
    }

    public function getSlugAttribute(): string
    {
        return $this->data['slug'] ?? '';
    }

    public function setSlugAttribute($value)
    {
        $this->data = array_merge($this->data ?? [], ['slug' => $value]);
    }

    public function getNameAttribute(): string
    {
        return $this->data['name'] ?? '';
    }

    public function setNameAttribute($value)
    {
        $this->data = array_merge($this->data ?? [], ['name' => $value]);
    }
}
