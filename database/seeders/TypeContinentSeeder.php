<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Continent;

class TypeContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $continents = [
            'Africa', 'Antarctica', 'Asia', 'Europe', 'North America', 'Australia', 'South America', 'Sea based'
        ];

        foreach ($continents as $continent) {
            Continent::firstOrCreate([
                'name' => $continent,
                'remarks' => 'seeder generated'
            ]);
        }
    }
}
