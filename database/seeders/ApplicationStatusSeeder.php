<?php

namespace Database\Seeders;

use App\Models\ApplicationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'pending', 
            'approved',
            'under evaluation',
        ];

        foreach($statuses as $s)
        {
            ApplicationStatus::firstOrCreate([
                'name' => $s,
                'remarks' => 'seeder generated',
            ]);
        }
    }
}
