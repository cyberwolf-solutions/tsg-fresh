<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryProduct extends Pivot
{
    protected $connection = 'tenant';
    protected $table = 'category_products';

    protected $fillable = [
        'product_id',
        'category_id',
    ];

    // timestamps disabled if your pivot table doesn't have them
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

