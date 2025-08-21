<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeResidence;

class ResidenceSeeder extends Seeder
{
    public function run(): void
    {
        $residences = [
            'Sariling bahay',
            'Nangungupanahan',
            'Nakikipisan'
        ];

        foreach ($residences as $residence) {
            TypeResidence::firstOrCreate([
                'name' => $residence,
                'remarks' => 'Seeder generated'
            ]);
        }
    }
}
