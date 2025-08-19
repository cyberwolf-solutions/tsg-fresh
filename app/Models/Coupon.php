<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
   
    use HasFactory, SoftDeletes;
    protected $connection = 'tenant';
    protected $table = 'coupons';
    protected $fillable = [
        'code',
        'type',
        'value',
        'expiry_date',
        'max_uses',
        'used_count',
        'active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }
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
}
