<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\UserPersonal;
use App\Models\UserAbroad;
use App\Models\UserFamily;
use App\Models\UserNeed;
use App\Models\Barangay;
use App\Models\TypeResidence;
use App\Models\Gender;
use App\Models\TypeId;
use App\Models\EducationalAttainment;
use App\Models\Religion;
use App\Models\CivilStatus;
use App\Models\Job;
use App\Models\SubJob;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Contract;
use App\Models\Owwa;
use App\Models\Need;
use App\Models\Relation;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $barangay   = Barangay::inRandomOrder()->first();
        $residence  = TypeResidence::inRandomOrder()->first();
        $gender     = Gender::inRandomOrder()->first();
        $typeId     = TypeId::inRandomOrder()->first();
        $education  = EducationalAttainment::inRandomOrder()->first();
        $religion   = Religion::inRandomOrder()->first();
        $civil      = CivilStatus::inRandomOrder()->first();
        
        if (! $barangay || ! $residence || ! $gender || ! $typeId || ! $education || ! $religion || ! $civil) {
            throw new \RuntimeException('Seed option tables first before running UserSeeder.');
        }

        for ($i = 1; $i <= 100; $i++) {
            $user = UserPersonal::create([
                'uuid'                      => (string)Str::uuid(),
                'first_name'                => "Juan{$i}",
                'middle_name'               => "Dela",
                'last_name'                 => "Cruz{$i}",
                'house_number'              => rand(100, 999),
                'street'                    => "Street {$i}",
                'barangay_id'               => $barangay->id,
                'city'                      => "Taguig City",
                'years_resident'            => rand(1, 20),
                'residence_type_id'         => $residence->id,
                'date_of_birth'             => now()->subYears(rand(20, 50))->format('Y-m-d'),
                'place_of_birth'            => "Taguig",
                'gender_id'                 => $gender->id,
                'type_id'                   => $typeId->id, 
                'voters'                    => rand(0,1) ? 'yes' : 'no',
                'educational_attainment_id' => $education->id,
                'religion_id'               => $religion->id,
                'civil_status_id'           => $civil->id,
                'present_job'               => "Worker {$i}",
                'status_id'                 => 1,
            ]);
            
            $subJob = SubJob::inRandomOrder()->first();
            $job    = $subJob ? Job::find($subJob->job_id) : Job::inRandomOrder()->first();
            
            $country   = Country::inRandomOrder()->first();
            $continent = $country ? Continent::find($country->continent_id) : Continent::inRandomOrder()->first();

            $contract = Contract::inRandomOrder()->first();
            $owwa     = Owwa::inRandomOrder()->first();
            
            if (! $job || ! $country || ! $continent || ! $contract || ! $owwa) {
                continue;
            }

            UserAbroad::create([
                'user_id'        => $user->id,
                'job_type'       => rand(0,1) ? 'landbased' : 'seabased',
                'job_id'         => $job->id,
                'sub_job_id'     => $subJob?->id,
                'continent_id'   => $continent->id,
                'country_id'     => $country->id,
                'contract_id'    => $contract->id,
                'abroad_years'   => rand(1, 10),
                'date_departure' => now()->subYears(rand(1,5))->format('Y-m-d'),
                'date_arrival'   => now()->subMonths(rand(1,12))->format('Y-m-d'),
                'owwa_id'        => $owwa->id,
                'intent_return'  => rand(0,1) ? 'yes' : 'no',
            ]);
            
            $relations = Relation::inRandomOrder()->limit(2)->get();
            foreach ($relations as $relation) {
                UserFamily::create([
                    'user_id'       => $user->id,
                    'full_name'     => "Family Member of {$user->last_name}",
                    'relation_id'   => $relation->id,
                    'date_of_birth' => now()->subYears(rand(5, 60))->format('Y-m-d'),
                    'work'          => "Job for {$relation->name}",
                    'income'        => rand(5000, 20000),
                    'voters'        => rand(0,1) ? 'yes' : 'no',
                ]);
            }
            
            $needs = Need::inRandomOrder()->limit(2)->get();
            foreach ($needs as $need) {
                UserNeed::create([
                    'user_id' => $user->id,
                    'need_id' => $need->id,
                ]);
            }
        }
    }
}
