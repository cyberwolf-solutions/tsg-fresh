<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'rooms';
    protected $fillable = [
        'name',
        'description',
        'room_no',
        // 'type',
        'image_url',
        'capacity',
        'size',
        // 'price',
        // 'price_lkr',
        // 'price_usd',
        // 'price_eu',
        'status',
        'passport_no',
        'next_destination',
        'nationality',
        'image_url',
        'created_by',
        'updated_by',
        'deleted_by',
        'RoomFacility_id'
    ];

    // public function type() {
    //     return $this->belongsTo(RoomType::class, 'type');
    // }

    // public function types() {
    //     return $this->hasOne(RoomType::class, 'id', 'type');
    // }

    public function pricings()
{
    return $this->hasMany(RoomPricing::class, 'room_id');
}

// Shortcut for getting the room type from pricing (assuming only one pricing per room for this use case)
public function roomType()
{
    return $this->hasOneThrough(RoomType::class, RoomPricing::class, 'room_id', 'id', 'id', 'room_type_id');
}

    public function bookings() {
        return $this->belongsToMany(Booking::class,'bookings_rooms','room_id','booking_id');
    }

    public function createdBy() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function deletedBy() {
        return $this->hasOne(User::class, 'id', 'deleted_by');
    }

    public function RoomFacility()
    {
        return $this->belongsTo(RoomFacilities::class, 'RoomFacility_id');
    }

    
}
