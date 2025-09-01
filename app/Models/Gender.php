<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;
    protected $table = 'genders';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllGenders()
    {
        return self::all();
    }

    public function userPersonals()
    {
        return $this->hasMany(UserPersonal::class, 'gender_id');
    }

    public function archivePersonals()
    {
        return $this->hasMany(ArchivePersonal::class, 'gender_id');
    }
}
