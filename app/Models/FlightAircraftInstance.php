<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightAircraftInstance extends Model
{
    /** @use HasFactory<\Database\Factories\FlightAircraftInstanceFactory> */
    use HasFactory;

    protected $table = 'flight_aircraft_instances';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'flight_call',
        'aircraft_instance_id',
    ];

    // Override getKeyName for composite key
    public function getKeyName()
    {
        return ['flight_call', 'aircraft_instance_id'];
    }

    // Relationships
    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_call', 'flight_call');
    }

    public function aircraftInstance()
    {
        return $this->belongsTo(AircraftInstance::class, 'aircraft_instance_id', 'aircraft_instance_id');
    }
}
