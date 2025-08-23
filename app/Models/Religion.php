<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    use HasFactory;
    protected $table = 'religions';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllReligions()
    {
        return self::all();
    }
    
    public function userPersonals()
    {
        return $this->hasMany(userPersonal::class, 'religion_id');
    }
}
