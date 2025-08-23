<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    use HasFactory;
    protected $table = 'continents';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllContinents()
    {
        return self::all();
    }

    public function country()
    {
        return $this->hasMany(Country::class, 'continent_id');
    }

    public function userAbroad()
    {
        return $this->hasMany(userAbroad::class, 'continent_id');
    }
}
