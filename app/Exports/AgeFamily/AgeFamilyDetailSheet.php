<?php

namespace App\Exports\AgeFamily;

use App\Models\UserFamily;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class AgeFamilyDetailSheet implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithTitle
{
    public function __construct(public string $ageBracket) {}

    public function title(): string
    {
        return 'Details';
    }

    public function query()
    {
        [$maxDob, $minDob] = $this->dobRangeForBracket($this->ageBracket);

        return UserFamily::query()
            ->whereNotNull('date_of_birth')
            ->when($maxDob, fn($q) => $q->whereDate('date_of_birth', '<=', $maxDob))
            ->when($minDob, fn($q) => $q->whereDate('date_of_birth', '>=', $minDob))
            ->with([
                'relation:id,name',
                'user:id,uuid,first_name,middle_name,last_name,house_number,street,barangay_id,city,voters,present_job',
                'user.barangay:id,name',
                'user.abroad.country:id,name',
                'user.abroad.job:id,name',
                'user.abroad.subJob:id,name',
                'user.abroad.contract:id,name',
                'user.abroad.owwa:id,name',
                'user.needs.need:id,name',
            ]);
    }

    public function headings(): array
    {
        return [
            'Applicant UUID',
            'Applicant Full Name',
            'Applicant Address',
            'Applicant Barangay',
            'Applicant City',
            'Applicant Voter',
            'Applicant Present Job',
            'Abroad Country',
            'Abroad Job Type',
            'Abroad Job',
            'Abroad Sub Job',
            'Abroad Contract',
            'Abroad Years',
            'Date Departure',
            'Date Arrival',
            'OWWA',
            'Intent to Return',
            'Family Full Name',
            'Family Age',
            'Family Relation',
            'Family Work',
            'Family Income',
            'Family Voter',
            'Needs',
        ];
    }

    public function map($row): array
    {
        $familyAge = $row->date_of_birth ? Carbon::parse($row->date_of_birth)->age : null;
        $familyRelation = optional($row->relation)->name;

        $user = $row->user;
        $applicantName = $user
            ? trim(collect([$user->first_name, $user->middle_name, $user->last_name])->filter()->join(' '))
            : null;

        $address = $user
            ? trim(collect([$user->house_number, $user->street])->filter()->join(' '))
            : null;

        $barangay = optional($user?->barangay)->name;
        $city     = $user?->city;
        $appVoter = isset($user?->voters) ? ($user->voters ? 'Yes' : 'No') : null;

        $abroad         = $user?->abroad;
        $abroadCountry  = optional($abroad?->country)->name;
        $abroadJobType  = $abroad?->job_type;
        $abroadJob      = optional($abroad?->job)->name;
        $abroadSubJob   = optional($abroad?->subJob)->name;
        $abroadContract = optional($abroad?->contract)->name;
        $abroadYears    = $abroad?->abroad_years;

        $dateDeparture  = $abroad?->date_departure ? Carbon::parse($abroad->date_departure)->toDateString() : null;
        $dateArrival    = $abroad?->date_arrival   ? Carbon::parse($abroad->date_arrival)->toDateString()   : null;
        $owwa           = optional($abroad?->owwa)->name;
        $intentReturn   = $abroad?->intent_return;

        $needsList = $user?->needs
            ? $user->needs->pluck('need.name')->filter()->unique()->values()->all()
            : [];
        $needsStr = empty($needsList) ? null : Str::limit(implode(', ', $needsList), 500, '…');

        return [
            $user?->uuid,
            $applicantName,
            $address,
            $barangay,
            $city,
            $appVoter,
            $user?->present_job,
            $abroadCountry,
            $abroadJobType,
            $abroadJob,
            $abroadSubJob,
            $abroadContract,
            $abroadYears,
            $dateDeparture,
            $dateArrival,
            $owwa,
            $intentReturn,
            $row->full_name,
            $familyAge,
            $familyRelation,
            $row->work,
            $row->income,
            isset($row->voters) ? ($row->voters ? 'Yes' : 'No') : null,
            $needsStr,
        ];
    }

    private function dobRangeForBracket(string $bracket): array
    {
        $today = now()->startOfDay();

        return match ($bracket) {
            '0-10'  => [$today,                 $today->copy()->subYears(10)],
            '11-20' => [$today->copy()->subYears(11), $today->copy()->subYears(20)],
            '21-99' => [null,                   $today->copy()->subYears(21)],
            default => [null, null],
        };
    }
}
