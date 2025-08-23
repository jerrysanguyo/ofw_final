<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    use HasFactory;
    protected $table = 'needs';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllNeeds()
    {
        return self::all();
    }

    public function userNeed()
    {
        return $this->hasMany(userNeed::class, 'need_id');
    }
}
