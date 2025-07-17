<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingsRooms extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $table = 'bookings_rooms';
    protected $fillable = [
        'booking_id',
        'room_id',
        'bording_id',
        'roomtype_id',
        'created_by',
        'updated_by',
    ];

    public function room()
    {
        return $this->hasOne(Room::class, 'id', 'room_id');
    }
}
