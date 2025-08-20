<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeId extends Model
{
    use HasFactory;
    protected $table = 'type_ids';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllTypeIds()
    {
        return self::all();
    }
}
