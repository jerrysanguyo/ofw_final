<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owwa extends Model
{
    use HasFactory;
    protected $table = 'owwas';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllOwwas()
    {
        return self::all();
    }

    public function userAbroad()
    {
        return $this->hasMany(UserAbroad::class, 'owwa_id');
    }

    public function archiveAbroad()
    {
        return $this->hasMany(ArchiveAbroad::class, 'owwa_id');
    }
}
