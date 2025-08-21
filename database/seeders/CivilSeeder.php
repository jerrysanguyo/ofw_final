<?php

namespace Database\Seeders;

use App\Models\CivilStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CivilSeeder extends Seeder
{
    public function run(): void
    {
        $civils = [
            'Single',
            'Married',
            'Widowed',
            'Legally Separated',
        ];

        foreach ($civils as $civil) {
            CivilStatus::firstOrCreate([
                    'name' => $civil,
                    'remarks' => 'Seeder generated'
            ]);
        }
    }
}
