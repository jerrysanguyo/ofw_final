<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userPersonal extends Model
{
    use HasFactory;
    protected $table = 'user_personals';
    protected $fillable = [
        'uuid',
        'house_number',
        'street',
        'barangay_id',
        'city',
        'years_resident',
        'residence_type_id',
        'date_of_birth',
        'place_of_birth',
        'gender_id',
        'type_id_id',
        'voters',
        'educational_attainment_id',
        'religion_id',
        'civil_status_id',
        'present_job',
    ];

    public static function getUserPersonal($uuid)
    {
        return self::where('uuid', $uuid)->first();
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'baragay_id');
    }

    public function residenceType()
    {
        return $this->belongsTo(TypeResidence::class, 'residence_type_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function typeId()
    {
        return $this->belongsTo(TypeId::class, 'type_id_id');
    }

    public function educationalAttainment()
    {
        return $this->belongsTo(EducationalAttainment::class, 'educational_attainment_id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }

    public function civilStatus()
    {
        return $this->belongsTo(CivilStatus::class, 'civil_status_id');
    }

    public function abroad()
    {
        return $this->hasMany(userAbroad::class, 'user_id');
    }
}
