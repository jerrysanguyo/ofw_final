<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubJob extends Model
{
    use HasFactory;
    protected $table = 'sub_jobs';
    protected $fillable = [
        'job_id',
        'name',
        'remarks',
    ];

    public static function getAllSubJobs()
    {
        return self::all();
    }

    public function Job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
