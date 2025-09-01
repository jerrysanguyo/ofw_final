<?php

namespace App\Exports\AgeFamily;

use App\Models\UserFamily;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class AgeFamilySummarySheet implements FromArray, WithHeadings, ShouldAutoSize, WithTitle
{
    public function __construct(public string $ageBracket) {}

    public function title(): string
    {
        return 'Summary';
    }

    public function headings(): array
    {
        return ['Age', 'Count'];
    }

    public function array(): array
    {
        [$minAge, $maxAge] = $this->ageRangeForBracket($this->ageBracket);
        
        $byAge = UserFamily::query()
            ->whereNotNull('date_of_birth')
            ->selectRaw('TIMESTAMPDIFF(YEAR, date_of_birth, ?) as age, COUNT(*) as cnt', [now()])
            ->groupBy('age')
            ->havingRaw('age BETWEEN ? AND ?', [$minAge, $maxAge])
            ->pluck('cnt', 'age')
            ->all();

        $rows  = [];
        $total = 0;

        for ($age = $minAge; $age <= $maxAge; $age++) {
            $count = (int)($byAge[$age] ?? 0);
            $rows[] = [$age, $count];
            $total += $count;
        }
        
        $rows[] = ['Total', $total];

        return $rows;
    }

    private function ageRangeForBracket(string $bracket): array
    {
        return match ($bracket) {
            '0-10'  => [0, 10], 
            '11-20' => [11, 20],
            '21-99' => [21, 99],
            default => [0, 0],
        };
    }
}
