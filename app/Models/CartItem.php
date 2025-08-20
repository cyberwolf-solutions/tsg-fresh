<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
   use HasFactory, SoftDeletes;
    protected $connection = 'tenant';
    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id',
        'product_id',
        'variant_id',
        'inventory_id',
        'quantity',
        'price',
        'total',
         'created_by',
        'updated_by',
        'deleted_by'
    ];

    // Each item belongs to a cart
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    // Item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Item may belong to a variant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // Item may belong to a specific inventory record
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
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
