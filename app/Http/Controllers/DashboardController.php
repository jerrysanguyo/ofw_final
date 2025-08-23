<?php

namespace App\Http\Controllers;

use App\Models\Continent;
use App\Models\UserAbroad;
use App\Models\UserPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $listOfContinent = Continent::getAllContinents();
        $listOfApplicant = UserPersonal::getAllUserPersonals();
        $totalOfw = UserAbroad::count();
        $landbased = UserAbroad::where('job_type', 'landbased')->count();
        $seabased = UserAbroad::where('job_type', 'seabased')->count();
        $submittedToday = UserPersonal::whereDate('created_at', today())->count();
        $chartDataJson = $this->geo();
        $distinctBeneficiary = $this->getBeneficiaryChart();
        $distinctNeeds       = $this->getNeedsChart();
        $distinctJobTypes    = $this->getJobTypeChart();

        return view('dashboard.index', compact(
            'totalOfw',
            'landbased',
            'seabased',
            'submittedToday',
            'listOfContinent',
            'listOfApplicant',
            'chartDataJson',
            'distinctBeneficiary',
            'distinctNeeds',
            'distinctJobTypes',
        ));
    }

    public function applicantCount(Request $request)
    {
        $validated = $request->validate([
            'startDate' => ['nullable', 'date'],
            'endDate'   => ['nullable', 'date'],
        ]);

        $tz = config('app.timezone', 'UTC');
        
        $start = isset($validated['startDate']) && $validated['startDate']
            ? Carbon::parse($validated['startDate'], $tz)->startOfDay()
            : null;

        $end = isset($validated['endDate']) && $validated['endDate']
            ? Carbon::parse($validated['endDate'], $tz)->endOfDay()
            : null;
            
        if ($start && $end && $start->gt($end)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
        }

        $query = UserPersonal::query();

        if ($start && $end) {
            $query->whereBetween('created_at', [$start, $end]);
        } elseif ($start) {
            $query->where('created_at', '>=', $start);
        } elseif ($end) {
            $query->where('created_at', '<=', $end);
        }

        $count = $query->count();

        return response()->json([
            'count'      => $count,
            'startDate'  => $start ? $start->toDateString() : null,
            'endDate'    => $end ? $end->toDateString()   : null,
        ]);
    }

    
    public function continentBreakdown(Request $request)
    {
        $validated = $request->validate([
            'continent_id' => ['required', 'integer', 'exists:continents,id'],
        ]);

        $continentId = (int) $validated['continent_id'];

        $total = UserAbroad::where('continent_id', $continentId)->count();
        
        $breakdown = UserAbroad::with(['country:id,name'])
            ->selectRaw('country_id, COUNT(*) as total')
            ->where('continent_id', $continentId)
            ->whereNotNull('country_id')
            ->groupBy('country_id')
            ->orderByDesc('total')
            ->get()
            ->map(function ($row) {
                return [
                    'country_id'   => $row->country_id,
                    'country_name' => optional($row->country)->name ?? 'Unknown',
                    'count'        => (int) $row->total,
                ];
            })
            ->values();
            
        $continent = Continent::select('id', 'name')->find($continentId);

        return response()->json([
            'total'     => $total,
            'continent' => $continent,
            'countries' => $breakdown,
        ]);
    }

    public function geoChart()
    {
        $countryCounts = DB::table('user_abroads as ua')
        ->join('countries as c', 'c.id', '=', 'ua.country_id')
        ->selectRaw('c.name as country_name, COUNT(*) as total')
        ->whereNotNull('ua.country_id')
        ->groupBy('c.name')
        ->orderByDesc('total')
        ->get();

        $chartData = [['Country', 'OFW']];
        foreach ($countryCounts as $row) {
            $chartData[] = [$row->country_name, (int) $row->total];
        }

        $chartDataJson = json_encode($chartData, JSON_UNESCAPED_UNICODE);
    }

    private function geo(): string
    {
        $countryCounts = DB::table('user_abroads as ua')
            ->join('countries as c', 'c.id', '=', 'ua.country_id')
            ->selectRaw('c.name as country_name, COUNT(*) as total')
            ->whereNotNull('ua.country_id')
            ->groupBy('c.name')
            ->orderByDesc('total')
            ->get();

        $chartData = [['Country', 'OFW']];
        foreach ($countryCounts as $row) {
            $chartData[] = [$row->country_name, (int) $row->total];
        }

        return json_encode($chartData, JSON_UNESCAPED_UNICODE);
    }    
    
    private function getBeneficiaryChart()
    {
        return DB::table('user_families as up')
            ->selectRaw("
                CASE
                  WHEN TIMESTAMPDIFF(YEAR, up.date_of_birth, CURDATE()) BETWEEN 0  AND 10 THEN '0–10'
                  WHEN TIMESTAMPDIFF(YEAR, up.date_of_birth, CURDATE()) BETWEEN 11 AND 20 THEN '11–20'
                  ELSE '21+'
                END as age_group
            ")
            ->selectRaw('COUNT(*) as beneficiaryCount')
            ->whereNotNull('up.date_of_birth')
            ->groupBy('age_group')
            ->orderByRaw("FIELD(age_group,'0–10','11–20','21+')")
            ->get();
    }
    
    private function getNeedsChart()
    {
        return DB::table('user_needs as un')
            ->join('needs as n', 'n.id', '=', 'un.need_id')
            ->selectRaw('n.name as type_name')
            ->selectRaw('COUNT(*) as needsCount')
            ->groupBy('type_name')
            ->orderByDesc('needsCount')
            ->get();
    }
    
    private function getJobTypeChart()
    {
        return DB::table('user_abroads')
            ->select('job_type')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('job_type')
            ->orderByDesc('count')
            ->get();
    }
}
