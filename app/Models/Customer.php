<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'tenant';
    protected $table = 'customers';
    protected $fillable = [
        'name',
        'contact',
        'email',
        'address',
        'company_name',
        'vat',
        'city',
        'state',
        'postalcode',
        'country',
        'loyality',
        'group',
        'created_by',
        'updated_by',
        'deleted_by',

    ];



    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function deletedBy()
    {
        return $this->hasOne(User::class, 'id', 'deleted_by');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
