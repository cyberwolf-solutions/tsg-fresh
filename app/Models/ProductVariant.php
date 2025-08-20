<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes;

    protected $connection = 'tenant';
    protected $table = 'product_variants';
    protected $fillable = [
        'product_id',
        'variant_name',
        'variant_price',
        'final_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
