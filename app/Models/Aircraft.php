<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    /** @use HasFactory<\Database\Factories\AircraftFactory> */
    use HasFactory;

    protected $table = 'aircraft';
    protected $primaryKey = 'aircraft_id';

    protected $fillable = [
        'aircraft_manufacturer_id',
        'model',
    ];

    // Relationships
    public function manufacturer()
    {
        return $this->belongsTo(AircraftManufacturer::class, 'aircraft_manufacturer_id', 'aircraft_manufacturer_id');
    }

    public function instances()
    {
        return $this->hasMany(AircraftInstance::class, 'aircraft_id', 'aircraft_id');
    }

    public function seats()
    {
        return $this->hasMany(AircraftSeat::class, 'aircraft_id', 'aircraft_id');
    }

    public function flightSeatPrices()
    {
        return $this->hasMany(FlightSeatPrice::class, 'aircraft_id', 'aircraft_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'aircraft_id', 'aircraft_id');
    }
}
