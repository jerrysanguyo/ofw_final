<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $table = 'contracts';
    protected $fillable = [
        'name',
        'remarks',
    ];

    public static function getAllContracts()
    {
        return self::all();
    }

    public function userAbroad()
    {
        return $this->hasMany(UserAbroad::class, 'contract_id');
    }

    public function archiveAbroad()
    {
        return $this->hasMany(ArchiveAbroad::class, 'contract_id');
    }
}
