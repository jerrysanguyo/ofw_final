<?php

namespace Database\Seeders;

use App\Models\Barangay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    public function run(): void
    {
        $barangays = [
            'Bagumbayan',
            'Bagong Tanyag',
            'Bambang',
            'Central Bicutan',
            'Central Signal Village',
            'Fort Bonifacio',
            'Hagonoy',
            'Ibayo-Tipas',
            'Ligid-Tipas',
            'Lower Bicutan',
            'Maharlika Village',
            'Napindan',
            'New Lower Bicutan',
            'North Daang Hari',
            'North Signal Village',
            'Palingon',
            'Pinagsama',
            'San Miguel',
            'Santa Ana',
            'South Daang Hari',
            'South Signal Village',
            'Tuktukan',
            'Ususan',
            'Upper Bicutan',
            'Wawa',
            'Comembo',
            'East Rembo',
            'Pembo',
            'South Cembo',
            'West Rembo',
            'Pitogo',
        ];

        foreach ($barangays as $barangay) {
            Barangay::firstOrCreate([
                'name' => $barangay,
                'remarks' => 'Seeder generated',
            ]);
        }
    }
}
