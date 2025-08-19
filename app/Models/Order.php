<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'tenant';
    protected $fillable = [
        'customer_id',
        'web_customer_id',
        'order_date',
        'type',
        'status',
        'payment_status',
        'discount',
        'vat',
        'total',
        'subtotal',
        'coupon_id',
        'coupon_code',
        'coupon_value',
        'coupon_type',
        'source',
        'delivery_method',
        'payment_method',
        'delivery_address',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function webCustomer()
    {
        // just define the relationship
        return $this->belongsTo(WebCustomer::class, 'web_customer_id');
    }


    public function nextStatuses(): array
    {
        // Normalize values (optional, depends on how you save them)
        $source = strtoupper($this->source);
        $delivery = strtolower($this->delivery_method);

        return match ($source) {
            'POS' => ['Pending', 'Complete'],

            'WEB' => match ($delivery) {
                'pickup' => ['Pending', 'Confirmed', 'Packed', 'Complete'],
                'shipping', 'delivery' => ['Pending', 'Confirmed', 'Packed', 'Out for Delivery', 'Complete'],
                default => ['Pending', 'Complete'],
            },

            default => ['Pending', 'Complete'],
        };
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
