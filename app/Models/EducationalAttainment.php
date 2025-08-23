<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalAttainment extends Model
{
    use HasFactory;
    protected $table = 'educational_attainments';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllEducationalAttainments()
    {
        return self::all();
    }

    public function userPersonals()
    {
        return $this->hasMany(userPersonal::class, 'educational_attainment_id');
    }
}
