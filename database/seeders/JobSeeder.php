<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;


class JobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            'Education',
            'Law & Government',
            'Health Care',
            'Service Industry',
            'Transport',
            'Arts',
            'Communications',
            'Construction',
            'Manufacturing',
            'Finance',
            'Business Administrtion',
            'Technology',
            'Sea Based'
        ];

        foreach ($jobs as $job) {
            Job::firstOrCreate([
                'name' => $job,
                'remarks' => 'Seeder generated'
            ]);
        }
    }
}
