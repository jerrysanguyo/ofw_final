<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Owwa;

class OwwaSeeder extends Seeder
{
    public function run(): void
    {
        $owwas = [
            'Member - Active',
            'Member - Expired',
            'Non-member'
        ];

        foreach ($owwas as $owwa) {
            Owwa::firstOrCreate([
                'name' => $owwa,
                'remarks' => 'Seeder generated'
            ]);
        }
    }
}
