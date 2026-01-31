<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $table = 'clients';
    protected $primaryKey = 'client_id';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'email',
        'passport',
        'iata_country_code',
    ];

    // Relationships
    public function country()
    {
        return $this->belongsTo(Country::class, 'iata_country_code', 'iata_country_code');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'client_id', 'client_id');
    }

    // Accessor for full name
    public function getFullNameAttribute()
    {
        $name = $this->first_name;
        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }
        $name .= ' ' . $this->last_name;
        return $name;
    }
}
