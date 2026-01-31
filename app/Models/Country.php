<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory;

    protected $table = 'countries';
    protected $primaryKey = 'iata_country_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'iata_country_code',
        'name',
    ];

    // Relationships
    public function airports()
    {
        return $this->hasMany(Airport::class, 'iata_country_code', 'iata_country_code');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'iata_country_code', 'iata_country_code');
    }
}
