<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        $contracts = [
            'Finished',
            'Unfinish'
        ];

        foreach ($contracts as $contract) {
            Contract::firstOrCreate([
                'name' => $contract,
                'remarks' => 'Seeder generated'
            ]);
        }
    }
}
