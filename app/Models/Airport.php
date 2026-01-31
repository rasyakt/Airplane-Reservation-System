<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    /** @use HasFactory<\Database\Factories\AirportFactory> */
    use HasFactory;

    protected $table = 'airports';
    protected $primaryKey = 'iata_airport_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'iata_airport_code',
        'name',
        'city',
        'iata_country_code',
    ];

    // Relationships
    public function country()
    {
        return $this->belongsTo(Country::class, 'iata_country_code', 'iata_country_code');
    }

    public function originSchedules()
    {
        return $this->hasMany(Schedule::class, 'origin_iata_airport_code', 'iata_airport_code');
    }

    public function destinationSchedules()
    {
        return $this->hasMany(Schedule::class, 'dest_iata_airport_code', 'iata_airport_code');
    }
}
