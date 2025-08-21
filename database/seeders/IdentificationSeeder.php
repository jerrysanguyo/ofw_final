<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeId;

class IdentificationSeeder extends Seeder
{
    public function run(): void
    {
        $identifications = [
            'PSA-issued Certificate of Live Birth',
            'Philippine Passport',
            'Unified Multi-purpose ldentification',
            'Student\'s License Permit or Non- Professional/Professional\'s Driver License',
        ];

        foreach ($identifications as $identification) {
            TypeId::firstOrCreate([
                'name' => $identification,
                'remarks' => 'Seeder generated'
            ]);
        }
    }
}
