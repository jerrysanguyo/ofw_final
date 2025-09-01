<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'application_statuses';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllApplicationStatuses()
    {
        return self::all();
    }

    public function userPersonals()
    {
        return $this->hasMany(UserPersonal::class, 'status_id');
    }
}
