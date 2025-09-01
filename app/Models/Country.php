<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    protected $fillable = [
        'continent_id',
        'name',
        'remarks',
    ];

    public static function getAllCountries()
    {
        return self::all();
    }

    public function continent()
    {
        return $this->belongsTo(Continent::class, 'continent_id');
    }

    public function userAbroad()
    {
        return $this->hasMany(UserAbroad::class, 'country_id');
    }

    public function arhiveAbroad()
    {
        return $this->hasMany(ArchiveAbroad::class, 'country_id');
    }
}
