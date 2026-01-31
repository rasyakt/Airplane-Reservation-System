<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'client_id',
        'flight_call',
        'aircraft_id',
        'seat_id',
        'confirmation_code',
        'payment_status',
    ];

    // Override getKeyName for composite key
    public function getKeyName()
    {
        return ['client_id', 'flight_call', 'aircraft_id', 'seat_id'];
    }

    // Automatically generate confirmation code
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->confirmation_code)) {
                $booking->confirmation_code = strtoupper(Str::random(10));
            }
        });
    }

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

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

    // Check if seat is available for a given flight
    public static function isSeatAvailable($flightCall, $seatId)
    {
        return !self::where('flight_call', $flightCall)
            ->where('seat_id', $seatId)
            ->exists();
    }
}
