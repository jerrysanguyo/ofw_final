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
        return $this->hasMany(UserPersonal::class, 'educational_attainment_id');
    }

    public function archivePersonals()
    {
        return $this->hasMany(ArchivePersonal::class, 'educational_attainment_id');
    }
}
