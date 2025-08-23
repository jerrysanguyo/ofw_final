<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;
    protected $table = 'barangays';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllBarangays()
    {
        return self::all();
    }

    public function userPersonals()
    {
        return $this->hasMany(userPersonal::class, 'barangay_id');
    }
}
