<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $table = 'schedules';
    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'origin_iata_airport_code',
        'dest_iata_airport_code',
        'departure_time_gmt',
        'arrival_time_gmt',
        'callsign',
    ];

    protected $casts = [
        'departure_time_gmt' => 'datetime',
        'arrival_time_gmt' => 'datetime',
    ];

    // Relationships
    public function originAirport()
    {
        return $this->belongsTo(Airport::class, 'origin_iata_airport_code', 'iata_airport_code');
    }

    public function destinationAirport()
    {
        return $this->belongsTo(Airport::class, 'dest_iata_airport_code', 'iata_airport_code');
    }

    public function flights()
    {
        return $this->hasMany(Flight::class, 'schedule_id', 'schedule_id');
    }
}
