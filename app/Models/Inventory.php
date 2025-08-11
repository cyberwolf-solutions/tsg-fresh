<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $table = 'inventory';
    protected $fillable = [
        'product_id',
        'variant_id',
        'name',
        'unit_price',
        'quantity',
        'min_quantity',
        'unit',
        'description',
        'manufacture_date',
        'expiry_date',
        'created_by',
        'updated_by',
        'deleted_by'
    ];



    // public function products()
    // {
    //     return $this->belongsToMany(Product::class,'products_ingredients','ingredient_id','product_id');
    // }

    // public function modifiers()
    // {
    //     return $this->belongsToMany(Modifier::class,'modifiers_ingredients','ingredient_id','modifier_id');
    // }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
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
