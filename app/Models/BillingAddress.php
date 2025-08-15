<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    use HasFactory;
    protected $table = 'billing_addresses';

    protected $fillable = [
        'customer_id',
        'first_name',
        'last_name',
        'street_address',
        'town',
        'phone',
        'email'
    ];

    // In BillingAddress.php
    public function customer()
    {
        return $this->belongsTo(WebCustomer::class, 'customer_id');
    }
    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class);
    // }
}
