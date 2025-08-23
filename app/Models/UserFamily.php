<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFamily extends Model
{
    use HasFactory;
    protected $table = 'user_families';
    protected $fillable = [
        'user_id',
        'full_name',
        'relation_id',
        'date_of_birth',
        'work',
        'income',
        'voters',
    ];

    public static function getUserFamilies($userId)
    {
        return self::where('user_id', $userId)->get();
    }

    public function relation()
    {
        return $this->belongsTo(Relation::class, 'relation_id');
    }

    public function user()
    {
        return $this->belongsTo(UserPersonal::class, 'user_id');
    }
}
