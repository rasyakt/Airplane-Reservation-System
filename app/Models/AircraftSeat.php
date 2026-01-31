<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AircraftSeat extends Model
{
    /** @use HasFactory<\Database\Factories\AircraftSeatFactory> */
    use HasFactory;

    protected $table = 'aircraft_seats';
    protected $primaryKey = 'seat_id';

    protected $fillable = [
        'aircraft_id',
        'seat_number',
        'travel_class_id',
    ];

    // Relationships
    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class, 'aircraft_id', 'aircraft_id');
    }

    public function travelClass()
    {
        return $this->belongsTo(TravelClass::class, 'travel_class_id', 'travel_class_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'seat_id', 'seat_id');
    }

    public function flightSeatPrices()
    {
        return $this->hasMany(FlightSeatPrice::class, 'seat_id', 'seat_id');
    }
}
