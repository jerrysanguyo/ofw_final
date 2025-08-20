<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;
    protected $table = 'relations';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllRelations()
    {
        return self::all();
    }
}
