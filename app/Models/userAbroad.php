<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAbroad extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'job_type',
        'job_id',
        'sub_job_id',
        'continent_id',
        'country_id',
        'contract_id',
        'abroad_years',
        'date_departure',
        'date_arrival',
        'owwa_id',
        'intent_return',
    ];

    public static function getUserAbroad($userId)
    {
        return self::where('user_id', $userId)->first();
    }

    public function user()
    {
       return $this->belongsTo(UserPersonal::class, 'user_id'); 
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function subJob()
    {
        return $this->belongsTo(SubJob::class, 'sub_job_id');
    }

    public function continent()
    {
        return $this->belongsTo(Continent::class, 'continent_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function owwa()
    {
        return $this->belongsTo(Owwa::class, 'owwa_id');
    }
}
