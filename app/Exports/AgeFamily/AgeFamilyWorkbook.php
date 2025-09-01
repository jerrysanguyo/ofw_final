<?php

namespace App\Exports\AgeFamily;

use App\Exports\AgeFamily\AgeFamilyDetailSheet;
use App\Exports\AgeFamily\AgeFamilySummarySheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AgeFamilyWorkbook implements WithMultipleSheets
{
    public function __construct(public string $ageBracket) {}

    public function sheets(): array
    {
        return [
            new AgeFamilySummarySheet($this->ageBracket),
            new AgeFamilyDetailSheet($this->ageBracket),
        ];
    }
}
