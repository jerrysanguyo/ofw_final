<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeResidence extends Model
{
    use HasFactory;
    protected $table = 'type_residences';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllTypeResidences()
    {
        return self::all();
    }

    public function userPersonals()
    {
        return $this->hasMany(userPersonal::class, 'residence_type_id');
    }
}
