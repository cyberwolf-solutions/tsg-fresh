<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'tenant';
    protected $table = 'carts';
    protected $fillable = [
        'customer_id',
        'session_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    // A cart belongs to a customer (optional)
    public function customer()
    {
        return $this->belongsTo(WebCustomer::class, 'customer_id');
    }


    // A cart has many items
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    // Calculate cart total
    public function getTotalAttribute()
    {
        return $this->items->sum('total');
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
