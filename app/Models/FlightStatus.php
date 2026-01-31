<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightStatus extends Model
{
    /** @use HasFactory<\Database\Factories\FlightStatusFactory> */
    use HasFactory;

    protected $table = 'flight_statuses';
    protected $primaryKey = 'flight_status_id';

    protected $fillable = [
        'name',
    ];

    // Relationships
    public function flights()
    {
        return $this->hasMany(Flight::class, 'flight_status_id', 'flight_status_id');
    }
}
