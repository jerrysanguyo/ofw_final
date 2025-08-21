<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Need;

class NeedSeeder extends Seeder
{
    public function run(): void
    {
        $needs = [
            'Medicine',
            'Financial',
            'Food'
        ];

        foreach ($needs as $need) {
            Need::firstOrCreate([
                'name' => $need,
                'remarks' => 'Seeder generated'
            ]);
        }
    }
}
