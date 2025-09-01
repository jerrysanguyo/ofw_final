<?php

namespace App\Services;

use App\Models\UserAbroad;
use App\Models\UserFamily;
use App\Models\UserNeed;
use App\Models\UserPersonal;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class FormService
{
    public function formStore(string $uuid, array $data)
    {
        return DB::transaction(function () use ($uuid, $data) {
            $personal = UserPersonal::updateOrCreate(
                ['uuid' => $uuid],
                [
                    'first_name'                 => $data['first_name'],
                    'middle_name'                => $data['middle_name'] ?? null,
                    'last_name'                  => $data['last_name'],
                    'house_number'               => $data['house_number'],
                    'street'                     => $data['street'] ?? null,
                    'barangay_id'                => $data['barangay'],
                    'city'                       => $data['city'],
                    'years_resident'             => $data['years_resident'],
                    'residence_type_id'          => $data['residence_type'],
                    'date_of_birth'              => $data['birthdate'],
                    'place_of_birth'             => $data['place_of_birth'],
                    'gender_id'                  => $data['gender'],
                    'type_id'                    => $data['type_id'],
                    'voters'                     => $data['voters'],
                    'educational_attainment_id'  => $data['educational_attainment'],
                    'religion_id'                => $data['religion'],
                    'civil_status_id'            => $data['civil_status'],
                    'present_job'                => $data['present_job'] ?? null,
                    'status_id'                  => 1,
                ]
            );

            $status = 'active';

            if (!empty($data['last_departure'])) {
                $departure = Carbon::parse($data['last_departure']);
                $yearsDiff = $departure->diffInYears(Carbon::now());

                $status = $yearsDiff >= 2 ? 'inactive' : 'active';
            }
            
            UserAbroad::updateOrCreate(
                ['user_id' => $personal->id],
                [
                    'job_type'       => $data['job_type'],
                    'job_id'         => $data['job'],
                    'sub_job_id'     => $data['sub_job'],
                    'continent_id'   => $data['continent'],
                    'country_id'     => $data['country'],
                    'contract_id'    => $data['contract'],
                    'abroad_years'   => $data['years_abroad'],
                    'date_departure' => $data['last_departure'] ?? null,
                    'date_arrival'   => $data['last_arrival'] ?? null,
                    'owwa_id'        => $data['owwa'] ?? null,
                    'intent_return'  => $data['intent_return'],
                    'status'         => $status,
                ]
            );

            $needIds = collect(Arr::get($data, 'needs.need_id', []))
                ->filter()
                ->unique()
                ->values();

            UserNeed::where('user_id', $personal->id)->delete();

            if ($needIds->isNotEmpty()) {
                UserNeed::insert(
                    $needIds->map(fn ($id) => [
                        'user_id'    => $personal->id,
                        'need_id'    => (int) $id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])->all()
                );
            }
            
            $h = Arr::get($data, 'household', []);
            $count = count($h['full_name'] ?? []);
            UserFamily::where('user_id', $personal->id)->delete();

            if ($count > 0) {
                $rows = collect(range(0, $count - 1))
                    ->map(function ($i) use ($h, $personal) {
                        $full = trim($h['full_name'][$i] ?? '');
                        if ($full === '') return null;

                        $birth = $h['birthdate'][$i] ?? null;
                        $age   = $birth ? Carbon::parse($birth)->age : null;
                        $votersRaw = $h['voters'][$i] ?? 'no';
                        $votersStr = in_array(strtolower((string)$votersRaw), ['yes','y','true','1'], true) ? 'yes' : 'no';

                        return [
                            'user_id'        => (int) $personal->id,
                            'full_name'      => $full,
                            'relation_id'    => filled($h['relation_id'][$i] ?? null) ? (int) $h['relation_id'][$i] : null,
                            'date_of_birth'      => $birth ?: null,
                            'work'           => trim($h['work'][$i] ?? ''),
                            'income' => is_numeric($h['monthly_income'][$i] ?? null) ? (float) $h['monthly_income'][$i] : 0,
                            'voters'         => $votersStr, 
                            'created_at'     => now(),
                            'updated_at'     => now(),
                        ];
                    })
                    ->filter()
                    ->values()
                    ->all();

                if (!empty($rows)) {
                    UserFamily::insert($rows);
                }
            }

            return $personal;
        });
    }
}