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

    /**
     * Set the keys for a save update query.
     */
    protected function setKeysForSaveQuery($query)
    {
        $query->where('flight_call', '=', $this->getAttribute('flight_call'))
            ->where('aircraft_instance_id', '=', $this->getAttribute('aircraft_instance_id'));
        return $query;
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
