<?php

namespace Database\Seeders;

use App\Models\EducationalAttainment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        $educations = [
            'Primary',
            'Secondary',
            'Upper secondary',
            'Vocational',
            'Bachelor\'s',
            'Graduate',
            'Doctoral'
        ];

        foreach ($educations as $education) {
            EducationalAttainment::firstOrCreate([
                'name' => $education,
                'remarks' => 'Seeder generated'
            ]);
        }
    }
}
