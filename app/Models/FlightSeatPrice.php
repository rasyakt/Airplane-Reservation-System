<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightSeatPrice extends Model
{
    /** @use HasFactory<\Database\Factories\FlightSeatPriceFactory> */
    use HasFactory;

    protected $table = 'flight_seat_prices';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'flight_call',
        'aircraft_id',
        'seat_id',
        'price_usd',
    ];

    protected $casts = [
        'price_usd' => 'decimal:2',
    ];

    // Override getKeyName for composite key
    public function getKeyName()
    {
        return ['flight_call', 'aircraft_id', 'seat_id'];
    }

    // Relationships
    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_call', 'flight_call');
    }

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class, 'aircraft_id', 'aircraft_id');
    }

    public function seat()
    {
        return $this->belongsTo(AircraftSeat::class, 'seat_id', 'seat_id');
    }
}
