<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivePersonal extends Model
{
    use HasFactory;
    protected $table = 'archive_personals';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'house_number',
        'street',
        'barangay_id',
        'city',
        'years_resident',
        'residence_type_id',
        'date_of_birth',
        'place_of_birth',
        'gender_id',
        'type_id',
        'voters',
        'educational_attainment_id',
        'religion_id',
        'civil_status_id',
        'present_job',
    ];

    public static function getArchivePersonal($archiveId)
    {
        return self::where('id', $archiveId)->first();
    }

    public static function getAllArchivePersonals()
    {
        return self::all();
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
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
        return $this->belongsTo(TypeId::class, 'type_id');
    }

    public function educational()
    {
        return $this->belongsTo(EducationalAttainment::class, 'educational_attainment_id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }

    public function civil()
    {
        return $this->belongsTo(CivilStatus::class, 'civil_status_id');
    }

    public function archiveAbroads()
    {
        return $this->hasOne(ArchiveAbroad::class, 'user_id');
    }
}
