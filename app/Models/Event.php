<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = [
        'name',
        'date',
        'time',
        'barangay_id',
        'status',
        'venue',
        'remarks',
    ];

    public static function getEventDetails($eventId)
    {
        return self::where('id', $eventId)->first();
    }

    public static function getAllEvents()
    {
        return self::all();
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }
}
