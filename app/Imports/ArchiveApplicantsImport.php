<?php

namespace App\Imports;

use App\Models\ArchivePersonal;
use App\Models\ArchiveAbroad;
use App\Models\ArchiveFamily;
use App\Models\ArchiveNeed;
use App\Models\Barangay;
use App\Models\Job;
use App\Models\SubJob;
use App\Models\Country;
use App\Models\Continent;
use App\Models\Contract;
use App\Models\Owwa;
use App\Models\TypeResidence;
use App\Models\Gender;
use App\Models\TypeId;
use App\Models\EducationalAttainment;
use App\Models\Religion;
use App\Models\CivilStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ArchiveApplicantsImport implements ToCollection, WithHeadingRow
{
    protected array $applicantIndex = [];

    public function collection(Collection $rows)
    {
        $rowNum = 1;
        foreach ($rows as $row) {
            $rowNum++;
            
            $fullName     = $this->str($row['applicant_full_name'] ?? '');
            $address      = $this->str($row['applicant_address'] ?? '');
            $barangayName = $this->str($row['applicant_barangay'] ?? '');
            $city         = $this->str($row['applicant_city'] ?? '');
            $voter   = $this->yesNoEnum($row['applicant_voter'] ?? null);
            $presentJob   = $this->str($row['applicant_present_job'] ?? '');
            $yearsResident     = $this->intOrNull($row['years_resident'] ?? null);
            $residenceTypeName = $this->str($row['residence_type'] ?? '');
            $appDob            = $this->dateOrNull($row['date_of_birth'] ?? null);
            $placeOfBirth      = $this->str($row['place_of_birth'] ?? '');
            $genderName        = $this->str($row['gender'] ?? '');
            $typeIdName        = $this->str($row['type_id'] ?? '');
            $educName          = $this->str($row['educational_attainment'] ?? '');
            $religionName      = $this->str($row['religion'] ?? '');
            $civilStatusName   = $this->str($row['civil_status'] ?? '');
            
            $countryName  = $this->str($row['abroad_country'] ?? '');
            $continentName = $this->str($row['continent'] ?? '');
            $jobType      = $this->jobType($row['abroad_job_type'] ?? '');
            $jobName      = $this->str($row['abroad_job'] ?? '');
            $subJobName   = $this->str($row['abroad_sub_job'] ?? '');
            $contractName = $this->str($row['abroad_contract'] ?? '');
            $yearsAbroad  = $this->intOrNull($row['abroad_years'] ?? null);
            $dateDep      = $this->dateOrNull($row['date_departure'] ?? null);
            $dateArr      = $this->dateOrNull($row['date_arrival'] ?? null);
            $owwaStatus   = $this->str($row['owwa'] ?? '');
            $intentReturn = $this->yesNoEnum($row['intent_to_return'] ?? null);
            
            $famFullName  = $this->str($row['family_full_name'] ?? '');
            $famDob       = $this->dateOrNull($row['family_date_of_birth'] ?? null);
            $famRelation  = $this->str($row['family_relation'] ?? '');
            $famWork      = $this->str($row['family_work'] ?? '');
            $famIncome    = $this->intOrNull($row['family_income'] ?? null);
            $famVoter = $this->yesNoEnum($row['family_voter'] ?? null);

            $needsCsv     = $this->str($row['needs'] ?? '');

            if ($fullName === '' || $address === '') {
                throw new \RuntimeException("Row {$rowNum}: Applicant name/address is required.");
            }
            
            $barangayId      = $this->mustLookupId($rowNum, Barangay::class, 'name', $barangayName, 'Barangay');
            $residenceTypeId = $this->mustLookupId($rowNum, TypeResidence::class, 'name', $residenceTypeName, 'Residence Type');
            $genderId        = $this->mustLookupId($rowNum, Gender::class, 'name', $genderName, 'Gender');
            $typeId          = $this->mustLookupId($rowNum, TypeId::class, 'name', $typeIdName, 'Type ID');
            $educId          = $this->mustLookupId($rowNum, EducationalAttainment::class, 'name', $educName, 'Educational Attainment');
            $religionId      = $this->mustLookupId($rowNum, Religion::class, 'name', $religionName, 'Religion');
            $civilStatusId   = $this->mustLookupId($rowNum, CivilStatus::class, 'name', $civilStatusName, 'Civil Status');
            
            if ($yearsResident === null) {
                throw new \RuntimeException("Row {$rowNum}: years_resident is required.");
            }
            if ($appDob === null) {
                throw new \RuntimeException("Row {$rowNum}: date_of_birth is required or invalid date.");
            }
            if ($placeOfBirth === '') {
                throw new \RuntimeException("Row {$rowNum}: place_of_birth is required.");
            }

            DB::transaction(function () use (
                $rowNum, $fullName, $address, $city, $voter, $presentJob,
                $barangayId, $yearsResident, $residenceTypeId, $appDob, $placeOfBirth,
                $genderId, $typeId, $educId, $religionId, $civilStatusId,
                $countryName, $continentName, $jobType, $jobName, $subJobName, $contractName,
                $yearsAbroad, $dateDep, $dateArr, $owwaStatus, $intentReturn,
                $famFullName, $famDob, $famRelation, $famWork, $famIncome, $famVoter,
                $needsCsv
            ) {
                $dedupeKey = mb_strtolower("$fullName|$address");

                if (!isset($this->applicantIndex[$dedupeKey])) {
                    [$first, $middle, $last] = $this->splitName($fullName);

                    $ap = ArchivePersonal::create([
                        'first_name'                 => $first,
                        'middle_name'                => $middle,
                        'last_name'                  => $last,
                        'house_number'               => $this->houseNo($address),
                        'street'                     => $this->streetOnly($address),
                        'barangay_id'                => $barangayId,
                        'city'                       => $city ?: null,
                        'years_resident'             => $yearsResident,
                        'residence_type_id'          => $residenceTypeId,
                        'date_of_birth'              => $appDob,
                        'place_of_birth'             => $placeOfBirth,
                        'gender_id'                  => $genderId,
                        'type_id'                    => $typeId,
                        'educational_attainment_id'  => $educId,
                        'religion_id'                => $religionId,
                        'civil_status_id'            => $civilStatusId,
                        'voters'                     => $voter,
                        'present_job'                => $presentJob ?: null,
                    ]);

                    $this->applicantIndex[$dedupeKey] = $ap->id;

                    // $countryClean       = $this->cleanCountry($countryName);
                    // $continentClean = $this->cleanContinent($continentName);
                    // $countryName  = $this->str($row['abroad_country'] ?? '');
                    // $continentName = $this->str($row['continent'] ?? '');
                    
                    $continentId = $this->lookupId(Continent::class, 'name', $continentName);
                    if (!$continentId) {
                        if ($jobType === 'seabased') {
                            $continentId = $this->lookupId(Continent::class, 'name', self::SEABASED_CONTINENT_FALLBACK);
                        }
                        if (!$continentId) {
                            throw new \RuntimeException("Row {$rowNum}: Continent \"{$continentName}\" not found in reference table.");
                        }
                    }

                    $countryId = $this->lookupId(Country::class, 'name', $countryName);

                    if ($jobType === 'landbased' && !$countryId) {
                        throw new \RuntimeException("Row {$rowNum}: Country \"{$countryName}\" not found in reference table.");
                    }

                    $jobId      = $this->lookupId(Job::class, 'name', $jobName);
                    $subJobId   = $this->lookupId(SubJob::class, 'name', $subJobName);
                    $contractId = $this->lookupId(Contract::class, 'name', $contractName);
                    $owwaId     = $this->lookupId(Owwa::class, 'name', $owwaStatus);

                    ArchiveAbroad::firstOrCreate(
                        ['user_id' => $ap->id],
                        [
                            'job_type'       => $jobType,
                            'job_id'         => $jobId,
                            'sub_job_id'     => $subJobId,
                            'continent_id'   => $continentId,
                            'country_id'     => $countryId, 
                            'contract_id'    => $contractId,
                            'abroad_years'   => $yearsAbroad,
                            'date_departure' => $dateDep,
                            'date_arrival'   => $dateArr,
                            'owwa_id'        => $owwaId,
                            'intent_return'  => $intentReturn,
                        ]
                    );
                    
                    $needs = $this->parseCsv($needsCsv);
                    foreach ($needs as $needName) {
                        $needId = $this->lookupId(\App\Models\Need::class, 'name', $needName);
                        if ($needId) {
                            ArchiveNeed::firstOrCreate([
                                'user_id' => $ap->id,
                                'need_id' => $needId,
                            ]);
                        }
                    }
                }

                $userId = $this->applicantIndex[$dedupeKey];
                
                if ($famFullName !== '' || $famRelation !== '' || $famWork !== '' || $famIncome !== null || $famDob !== null) {
                    $relationId = $this->lookupId(\App\Models\Relation::class, 'name', $famRelation);
                    ArchiveFamily::create([
                        'user_id'       => $userId,
                        'full_name'     => $famFullName ?: null,
                        'relation_id'   => $relationId,
                        'date_of_birth' => $famDob,
                        'work'          => $famWork ?: null,
                        'income'        => $famIncome,
                        'voters'        => $famVoter,
                    ]);
                }
            });
        }
    }

    protected function mustLookupId(int $rowNum, string $modelClass, string $col, ?string $value, string $label): int
    {
        $id = $this->lookupId($modelClass, $col, $value);
        if (!$id) {
            throw new \RuntimeException("Row {$rowNum}: {$label} \"{$value}\" not found in reference table.");
        }
        return $id;
    }

    protected function str($v): string { return trim((string)$v); }
    protected function yesNo($v): ?bool {
        $s = mb_strtolower(trim((string)$v));
        if (in_array($s, ['yes','y','1'], true)) return true;
        if (in_array($s, ['no','n','0'], true))  return false;
        return null;
    }
    protected function intOrNull($v): ?int { if ($v === null || $v === '') return null; return is_numeric($v) ? (int)$v : null; }
    protected function dateOrNull($v): ?string {
        if (!$v) return null;
        try {
            if (is_numeric($v)) {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v))->format('Y-m-d');
            }
            return Carbon::parse($v)->format('Y-m-d');
        } catch (\Throwable $e) { return null; }
    }
    protected function jobType($v): ?string {
        $s = mb_strtolower(trim((string)$v));
        if (in_array($s, ['landbased','land based','land-base','land'])) return 'landbased';
        if (in_array($s, ['seabased','sea based','sea-base','sea'])) return 'seabased';
        return null;
    }
    protected function isJobTypeWord(string $v): bool {
        $s = mb_strtolower(trim($v));
        return in_array($s, ['landbased','land based','seabased','sea based','land','sea']);
    }
    protected function lookupId(string $modelClass, string $col, ?string $value): ?int {
        $value = $this->str($value ?? '');
        if ($value === '') return null;
        $rec = $modelClass::query()->whereRaw('LOWER('.$col.') = ?', [mb_strtolower($value)])->first();
        return $rec?->id;
    }
    protected function inferContinentId(?int $countryId): ?int {
        if (!$countryId) return null;
        $country = Country::find($countryId);
        return $country->continent_id ?? null;
    }
    protected function parseCsv(string $csv): array {
        if ($csv === '') return [];
        $parts = array_map(fn($s) => trim($s), explode(',', $csv));
        $parts = array_filter($parts, fn($s) => $s !== '');
        $seen = []; $out = [];
        foreach ($parts as $p) { $k = mb_strtolower($p); if (!isset($seen[$k])) { $seen[$k] = true; $out[] = $p; } }
        return $out;
    }
    protected function splitName(string $full): array {
        $tokens = preg_split('/\s+/', trim($full));
        if (!$tokens || count($tokens) === 0) return [null, null, null];
        if (count($tokens) === 1) return [$tokens[0], null, null];
        if (count($tokens) === 2) return [$tokens[0], null, $tokens[1]];
        $first = array_shift($tokens);
        $last2 = array_slice($tokens, -2);
        $middleArr = array_slice($tokens, 0, max(0, count($tokens) - 2));
        $middle = $middleArr ? implode(' ', $middleArr) : null;
        $last = implode(' ', $last2);
        return [$first, $middle, $last];
    }
    protected function houseNo(string $address): ?string {
        if (preg_match('/^\s*([0-9A-Za-z\-#]+)/', $address, $m)) return $m[1];
        return null;
    }
    protected function streetOnly(string $address): ?string {
        $addr = trim($address);
        $addr = preg_replace('/^\s*[0-9A-Za-z\-#]+\s*/', '', $addr);
        return $addr !== '' ? $addr : null;
    }
    protected function yesNoEnum($v): ?string
    {
        $s = mb_strtolower(trim((string)$v));
        if (in_array($s, ['yes','y','1','true'], true)) return 'Yes';
        if (in_array($s, ['no','n','0','false'], true))  return 'No';
        return null;
    }
    
    protected const SEABASED_CONTINENT_FALLBACK = 'International Waters';

    protected function cleanCountry(string $v): string
    {
        $s = trim($v);
        if ($this->isJobTypeWord($s)) return '';
        $aliases = [
            'united states' => 'United States of America',
            'usa'           => 'United States of America',
            'u.s.a.'        => 'United States of America',
            'uk'            => 'United Kingdom',
            'u.k.'          => 'United Kingdom',
            'viet nam'      => 'Vietnam',
            'south korea'   => 'Korea, Republic of',
            'north korea'   => "Korea, Democratic People's Republic of",
        ];
        $k = mb_strtolower($s);
        return $aliases[$k] ?? $s;
    }

    protected function cleanContinent(string $v): string
    {
        $s = trim($v);
        if ($this->isJobTypeWord($s)) return '';
        return $s;
    }

    protected function continentAlias(string $name): string
    {
        $k = mb_strtolower(trim($name));
        $aliases = [
            'australia'      => 'Oceania',
            'australasia'    => 'Oceania',
            'oceania'        => 'Oceania',
            'north america'  => 'North America',
            'south america'  => 'South America',
            'asia'           => 'Asia',
            'europe'         => 'Europe',
            'africa'         => 'Africa',
            'antarctica'     => 'Antarctica',
            'international waters' => 'International Waters',
        ];
        return $aliases[$k] ?? $name;
    }
}