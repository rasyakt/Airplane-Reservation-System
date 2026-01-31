<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AircraftManufacturer extends Model
{
    /** @use HasFactory<\Database\Factories\AircraftManufacturerFactory> */
    use HasFactory;

    protected $table = 'aircraft_manufacturers';
    protected $primaryKey = 'aircraft_manufacturer_id';

    protected $fillable = [
        'name',
    ];

    // Relationships
    public function aircraft()
    {
        return $this->hasMany(Aircraft::class, 'aircraft_manufacturer_id', 'aircraft_manufacturer_id');
    }
}
