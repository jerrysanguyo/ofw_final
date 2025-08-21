<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'jobs';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllJobs()
    {
        return self::all();
    }

    public function subJob()
    {
        return $this->hasMany(SubJob::class, 'job_id');
    }
}
