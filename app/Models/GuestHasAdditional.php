<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestHasAdditional extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'guest_has_additional_payments';

    protected $fillable = [
        'customer_id',
        'additional_payment_id',
        'price',
        'created_by',

    ];


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
