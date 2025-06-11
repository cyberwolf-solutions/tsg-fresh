<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalPayment extends Model
{
    use HasFactory;

    protected $table = 'additional_payment';

    protected $fillable = [
        'description',
        'name',
        
        'created_by',
        
    ];


    public function createdBy() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }


    public function updatedBy() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function deletedBy() {
        return $this->hasOne(User::class, 'id', 'deleted_by');
    }
}
