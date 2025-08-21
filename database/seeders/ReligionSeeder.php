<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Religion;

class ReligionSeeder extends Seeder
{
    public function run(): void
    {
        $religions = [
            'Catholic',
            'Christian',
            'Islam',
            'Protestantism',
            'Seventh-day Adventist',
            'Church of jesus christ of latter day saints',
            'The Most Holy Church of God in Christ Jesus',
            'Convention of Philippine Baptist Churches',
            'Iglesia Filipina Independiente',
            'Iglesia Ni Cristo',
            'Non-denominational',
            'Baptist',
            'Jehovahs Witnesses',
        ];

        foreach ($religions as $religion) {
            Religion::firstOrCreate([
                'name' => $religion,
                'remarks' => 'Seeder generated'
            ]);
        }
    }
}
