<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Continent;
use App\Models\Country;

class TypeCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $countries = [
            'Africa' => ['Nigeria', 'Kenya', 'South Africa', 'Egypt', 'Ethiopia', 'Ghana', 'Morocco', 'Uganda', 'Algeria', 'Sudan'],
            'Antarctica' => ['N/A'],
            'Asia' => ['Japan', 'China', 'India', 'South Korea', 'Indonesia', 'Pakistan', 'Bangladesh', 'Vietnam', 'Philippines', 'Thailand'],
            'Europe' => ['Germany', 'France', 'Italy', 'Spain', 'Poland', 'Romania', 'Netherlands', 'Belgium', 'Greece', 'Portugal'],
            'North America' => ['United States', 'Canada', 'Mexico', 'Guatemala', 'Honduras', 'El Salvador', 'Nicaragua', 'Costa Rica', 'Panama', 'Belize'],
            'Australia' => ['Australia', 'New Zealand', 'Papua New Guinea', 'Fiji', 'Solomon Islands', 'Vanuatu', 'Samoa', 'Tonga', 'Tuvalu', 'Nauru'],
            'South America' => ['Brazil', 'Argentina', 'Chile', 'Colombia', 'Peru', 'Venezuela', 'Ecuador', 'Bolivia', 'Paraguay', 'Uruguay'],
            'Sea based' => ['Sea based'],
        ];

        foreach ($countries as $continent => $countryList) {
            $continentModel = Continent::where('name', $continent)->first();

            foreach ($countryList as $country) {
                Country::firstOrCreate([
                    'continent_id' => $continentModel->id,
                    'name' => $country,
                    'remarks' => 'seeder generated'
                ]);
            }
        }
    }
}
