<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'tenant';
    protected $table = 'products';
    protected $fillable = [
        'name',
        'image_url',
        'description',
        'product_code',
        'barcode',
        'brand_id',
        'product_unit',
        'cost',
        'product_price',
        'qty',
        'tax',
        'tax_method',
        'tax_status',
        'tax_class',
        'product_type',
        'status',
        'final_price',
        'created_by',
        'updated_by',
        'deleted_by'
    ];




    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products')
            ->using(CategoryProduct::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }


    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
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
