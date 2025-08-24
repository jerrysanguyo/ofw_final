<?php

namespace App\Exports;

use App\Models\UserAbroad;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CountryAbroadExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(public int $countryId) {}

    public function query()
    {
        return UserAbroad::query()
            ->where('country_id', $this->countryId)
            ->with([
                'country:id,name',
                'job:id,name',
                'subJob:id,name',
                'contract:id,name',
                'owwa:id,name',
                'user:id,uuid,first_name,middle_name,last_name,house_number,street,barangay_id,city,voters,present_job',
                'user.barangay:id,name',
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
            'Needs',
        ];
    }

    public function map($row): array
    {
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
        $abroadCountry  = optional($row->country)->name;
        $abroadJobType  = $row->job_type;
        $abroadJob      = optional($row->job)->name;
        $abroadSubJob   = optional($row->subJob)->name;
        $abroadContract = optional($row->contract)->name;
        $abroadYears    = $row->abroad_years;
        $dateDeparture  = $row->date_departure ? Carbon::parse($row->date_departure)->toDateString() : null;
        $dateArrival    = $row->date_arrival   ? Carbon::parse($row->date_arrival)->toDateString()   : null;
        $owwa           = optional($row->owwa)->name;
        $intentReturn   = $row->intent_return;
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
            $needsStr,
        ];
    }
}
