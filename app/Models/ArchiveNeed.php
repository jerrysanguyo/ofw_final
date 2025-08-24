<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveNeed extends Model
{
    use HasFactory;
    protected $table = 'archive_needs';
    protected $fillable = [
        'user_id',
        'need_id',
    ];

    public static function getUserNeeds($userId)
    {
        return self::where('user_id', $userId)->get();
    }

    public function user()
    {
        return $this->belongsTo(UserPersonal::class, 'user_id');
    }

    public function need()
    {
        return $this->belongsTo(Need::class, 'need_id');
    }
}
