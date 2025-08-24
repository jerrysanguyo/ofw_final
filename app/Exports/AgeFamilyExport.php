<?php

namespace App\Exports;

use App\Models\UserFamily;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AgeFamilyExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(public string $ageBracket) {}

    public function query()
    {
        [$maxDob, $minDob] = $this->dobRangeForBracket($this->ageBracket);

        return UserFamily::query()
            ->with('relation:id,name')
            ->whereNotNull('date_of_birth')
            ->when($maxDob, fn($q) => $q->whereDate('date_of_birth', '<=', $maxDob))
            ->when($minDob, fn($q) => $q->whereDate('date_of_birth', '>=', $minDob));
    }

    public function headings(): array
    {
        return ['Full Name', 'Age', 'Relation', 'Work', 'Income', 'Voter'];
    }

    public function map($row): array
    {
        $age = $row->date_of_birth ? Carbon::parse($row->date_of_birth)->age : null;

        return [
            $row->full_name,
            $age,
            optional($row->relation)->name,
            $row->work,
            $row->income,
            $row->voters ? 'Yes' : 'No',
        ];
    }

    private function dobRangeForBracket(string $bracket): array
    {
        $today = now()->startOfDay();

        return match ($bracket) {
            '0-10'  => [$today,               $today->copy()->subYears(10)],
            '11-20' => [$today->copy()->subYears(11), $today->copy()->subYears(20)],
            '21-99' => [$today->copy()->subYears(21), null],
            default => [null, null],
        };
    }
}