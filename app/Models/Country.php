<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'Countrys';
    protected $fillable = [
        'continent_id',
        'name',
        'remarks',
    ];

    public static function getAllCountries()
    {
        return self::all();
    }
}
