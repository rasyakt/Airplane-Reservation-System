<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /** @use HasFactory<\Database\Factories\FlightFactory> */
    use HasFactory;

    protected $table = 'flights';
    protected $primaryKey = 'flight_call';

    protected $fillable = [
        'schedule_id',
        'flight_status_id',
    ];

    // Relationships
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'schedule_id');
    }

    public function status()
    {
        return $this->belongsTo(FlightStatus::class, 'flight_status_id', 'flight_status_id');
    }

    public function aircraftInstances()
    {
        return $this->belongsToMany(
            AircraftInstance::class,
            'flight_aircraft_instances',
            'flight_call',
            'aircraft_instance_id'
        );
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'flight_call', 'flight_call');
    }

    public function flightSeatPrices()
    {
        return $this->hasMany(FlightSeatPrice::class, 'flight_call', 'flight_call');
    }
}
