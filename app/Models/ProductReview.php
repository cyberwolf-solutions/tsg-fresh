<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $table = 'product_reviews';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'customer_id',
        'review',
        'status',
        // 'created_by',
        // 'updated_by',
        // 'deleted_by'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        // just define the relationship
        return $this->belongsTo(WebCustomer::class, 'web_customer_id');
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
