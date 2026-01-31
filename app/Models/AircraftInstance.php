<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AircraftInstance extends Model
{
    /** @use HasFactory<\Database\Factories\AircraftInstanceFactory> */
    use HasFactory;

    protected $table = 'aircraft_instances';
    protected $primaryKey = 'aircraft_instance_id';

    protected $fillable = [
        'aircraft_id',
    ];

    // Relationships
    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class, 'aircraft_id', 'aircraft_id');
    }

    public function flights()
    {
        return $this->belongsToMany(
            Flight::class,
            'flight_aircraft_instances',
            'aircraft_instance_id',
            'flight_call'
        );
    }
}
