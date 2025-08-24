<?php

namespace App\Exports;

use App\Models\UserAbroad;
use Illuminate\Database\Eloquent\Builder;
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
            ->with(['country:id,name', 'user']);
    }

    public function headings(): array
    {
        return ['Full Name', 'Country', 'Job Type', 'Job', 'Sub Job', 'Abroad Years'];
    }

    public function map($row): array
    {
        $user = $row->user;
        $fullName = $user?->full_name
            ?? trim(collect([$user->first_name ?? null, $user->middle_name ?? null, $user->last_name ?? null])
                ->filter()
                ->join(' '));

        return [
            $fullName ?: '—',
            optional($row->country)->name,
            $row->job_type,
            optional($row->job)->name,
            optional($row->subJob)->name,
            $row->abroad_years,
        ];
    }
}
