<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Airport;

class Direction extends Model
{
    /** @use HasFactory<\Database\Factories\DirectionFactory> */
    use HasFactory;

    protected $table = 'directions';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'origin_iata_airport_code',
        'dest_iata_airport_code',
    ];

    // Override getKeyName for composite key
    public function getKeyName()
    {
        return ['origin_iata_airport_code', 'dest_iata_airport_code'];
    }

    // Relationships
    public function originAirport()
    {
        return $this->belongsTo(Airport::class, 'origin_iata_airport_code', 'iata_airport_code');
    }

    public function destinationAirport()
    {
        return $this->belongsTo(Airport::class, 'dest_iata_airport_code', 'iata_airport_code');
    }
}
