<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checkincheckout extends Model
{
    use HasFactory;
    protected $table = 'checkincheckout';

    protected $fillable = [
        'booking_id',
        'customer_id',
        'room_type',
        'room_facility_type',
        'room_no',
        'checkin',
        'checkout',
        'total_amount',
        'paid_amount',
        'due_amount',
        'status',
        'additional_payment',
        'full_payment',
        'note',
        'type',
        'ta',
        'full_payed_amount',
        'additional_services',
        'final_full_total'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type');
    }
    public function roomfacility()
    {
        return $this->belongsTo(RoomFacilities::class, 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_no', 'room_no');
    }

    
}
