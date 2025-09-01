<?php

namespace App\Http\Controllers;

use App\Exports\AgeFamily\AgeFamilyWorkbook;
use App\Exports\CountryAbroadExport;
use App\Models\Country;
use App\Models\UserAbroad;
use App\Models\UserFamily;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AgeFamilyExport;

class ReportController extends Controller
{
    public function index()
    {
        $listOfCountry = Country::getAllCountries();
        
        $defaultBracket = '0-10';
        $defaultAgeCount = $this->getAgeCount($defaultBracket);

        return view('report.index', compact(
            'listOfCountry',
            'defaultBracket',
            'defaultAgeCount'
        ));
    }

    public function ageCount(Request $request)
    {
        $data = $request->validate([
            'ageBracket' => ['required', Rule::in(['0-10','11-20','21-99'])],
        ]);

        return response()->json([
            'count' => $this->getAgeCount($data['ageBracket']),
        ]);
    }

    public function ageExport(Request $request)
    {
        $data = $request->validate([
            'ageBracket' => ['required', Rule::in(['0-10','11-20','21-99'])],
        ]);

        return Excel::download(
            new AgeFamilyWorkbook($data['ageBracket']),
            'age_report_'.$data['ageBracket'].'_'.now()->format('Ymd_His').'.xlsx'
        );
    }
    
    private function dobRangeForBracket(string $bracket): array
    {
        $today = CarbonImmutable::today();

        return match ($bracket) {
            '0-10'  => [$today,               $today->subYears(10)],
            '11-20' => [$today->subYears(11), $today->subYears(20)],
            '21-99' => [$today->subYears(21), null],
            default => [null, null],
        };
    }
    
    private function buildFamilyQuery(string $bracket)
    {
        [$maxDob, $minDob] = $this->dobRangeForBracket($bracket);

        return UserFamily::query()
            ->whereNotNull('date_of_birth')
            ->when($maxDob, fn($q) => $q->whereDate('date_of_birth', '<=', $maxDob))
            ->when($minDob, fn($q) => $q->whereDate('date_of_birth', '>=', $minDob));
    }
    
    private function getAgeCount(string $bracket): int
    {
        return $this->buildFamilyQuery($bracket)->count();
    }

    public function countryCount(Request $request)
    {
        $data = $request->validate([
            'country' => ['required', 'integer', 'exists:countries,id'],
        ]);

        return response()->json([
            'count' => $this->getCountryCount((int) $data['country']),
        ]);
    }

    public function countryExport(Request $request)
    {
        $data = $request->validate([
            'country' => ['required', 'integer', 'exists:countries,id'],
        ]);

        $countryId = (int) $data['country'];
        $countryName = optional(Country::find($countryId))->name ?? 'Country';

        return Excel::download(
            new CountryAbroadExport($countryId),
            'country_report_'.$countryName.'_'.now()->format('Ymd_His').'.xlsx'
        );
    }
    
    private function buildCountryQuery(int $countryId)
    {
        return UserAbroad::query()
            ->where('country_id', $countryId)
            ->with(['country:id,name', 'user']);
    }
    
    private function getCountryCount(int $countryId): int
    {
        return $this->buildCountryQuery($countryId)->count();
    }
}
