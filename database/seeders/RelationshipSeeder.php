<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Relation;

class RelationshipSeeder extends Seeder
{
    public function run(): void
    {
        $relations = [
            'Son', 
            'Daughter', 
            'Wife',
            'Husband',
            'Father',
            'Mother',
            'Sister',
            'Brother'
        ];

        foreach ($relations as $relation) {
            Relation::firstOrCreate([
                'name' => $relation,
                'remarks' => 'Seeder generated'
            ]);
        }
    }
}
