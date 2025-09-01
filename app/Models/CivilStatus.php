<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivilStatus extends Model
{
    use HasFactory;
    protected $table = 'civil_statuses';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllCivilStatuses()
    {
        return self::all();
    }

    public function userPersonals()
    {
        return $this->hasMany(UserPersonal::class, 'civil_status_id');
    }

    public function archivePersonals()
    {
        return $this->hasMany(ArchivePersonal::class, 'civil_status_id');
    }
}
