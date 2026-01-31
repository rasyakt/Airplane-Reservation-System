<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelClass extends Model
{
    /** @use HasFactory<\Database\Factories\TravelClassFactory> */
    use HasFactory;

    protected $table = 'travel_classes';
    protected $primaryKey = 'travel_class_id';

    protected $fillable = [
        'name',
        'description',
    ];

    // Relationships
    public function aircraftSeats()
    {
        return $this->hasMany(AircraftSeat::class, 'travel_class_id', 'travel_class_id');
    }
}
