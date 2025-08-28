<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppFormRequest;
use App\Models\Barangay;
use App\Models\CivilStatus;
use App\Models\Continent;
use App\Models\Contract;
use App\Models\Country;
use App\Models\EducationalAttainment;
use App\Models\Gender;
use App\Models\Job;
use App\Models\Need;
use App\Models\Owwa;
use App\Models\Relation;
use App\Models\Religion;
use App\Models\SubJob;
use App\Models\TypeId;
use App\Models\TypeResidence;
use App\Models\UserPersonal;
use App\Services\FormService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class FormController extends Controller
{
    protected $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    // private function userApi(?string $uuid): array
    // {
    //     if (empty($uuid)) return [];

    //     $SECRET_TOKEN = "super-secret-token-123";
    //     $ENDPOINT = "http://127.0.0.2:8000/api/users/{$uuid}";

    //     try {
    //         $resp = Http::withHeaders(['X-Api-Token' => $SECRET_TOKEN])
    //             ->timeout(10)->get($ENDPOINT);
    //     } catch (ConnectionException $e) {
    //         return [];
    //     }

    //     if ($resp->failed()) return [];
    //     if (($resp->json('echo_token') ?? null) !== $SECRET_TOKEN) return [];

    //     return $resp->json('data') ?? [];
    // }

    private function userApi(?string $uuid): array
    {
        if (empty($uuid)) {
            return [];
        }

        $token   = (string) config('services.partner_api.token');
        $baseUri = rtrim((string) config('services.partner_api.base_uri'), '/');
        $header  = (string) config('services.partner_api.header', 'X-Api-Token');
        $timeout = (int) config('services.partner_api.timeout', 10);
        
        if ($token === '' || $baseUri === '') {
            return [];
        }

        $endpoint = "{$baseUri}/api/users/{$uuid}";

        try {
            $resp = Http::withHeaders([$header => $token])
                ->timeout($timeout)
                ->get($endpoint);
        } catch (ConnectionException $e) {
            return [];
        }

        if ($resp->failed()) {
            return [];
        }
        
        if (($resp->json('echo_token') ?? null) !== $token) {
            return [];
        }

        return $resp->json('data') ?? [];
    }

    public function index()
    {
        // if (empty($uuid)) {
        //     abort(404, 'UUID is required');
        // }
        $barangays = Barangay::getAllBarangays();
        $residence_types = TypeResidence::getAllTypeResidences();
        $genders = Gender::getAllGenders();
        $ids = TypeId::getAllTypeIds();
        $educations = EducationalAttainment::getAllEducationalAttainments();
        $religions = Religion::getAllReligions();
        $civils = CivilStatus::getAllCivilStatuses();
        $jobs = Job::getAllJobs();
        $contracts = Contract::getAllContracts();
        $owwas = Owwa::getAllOwwas();
        $relations = Relation::getAllRelations();
        $needs = Need::getAllNeeds();
        $continents = Continent::getAllContinents();
        // $userDetails = $this->userApi($uuid);

        $userInfo     = UserPersonal::where('uuid', $uuid ?? '')->first();
        $previousJob  = $userInfo?->abroad;
        $households   = $userInfo?->families ?? collect();
        $userNeeds    = $userInfo?->needs()->pluck('need_id')->toArray() ?? [];
        return view('form.index', compact(
            'barangays',
            'residence_types',
            'genders',
            'ids',
            'educations',
            'religions',
            'civils',
            'jobs',
            'contracts',
            'owwas',
            'relations',
            'needs',
            'continents',
            // 'userDetails',
            'userInfo',
            'previousJob',
            'households',
            'userNeeds',
        ));
    }

    public function getByJob($jobId)
    {
        $subJobs = SubJob::where('job_id', $jobId)->get(['id', 'name']);
        
        return response()->json($subJobs);
    }
    
    public function getByContinent($continentId)
    {
        if (!ctype_digit((string) $continentId)) {
            return response()->json([], 400);
        }

        $countries = Country::where('continent_id', $continentId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($countries);
    }

    public function AppFormStore(AppFormRequest $request, $uuid)
    {
        $form = $this->formService->formStore($uuid, $request->validated());

        activity()
            ->performedOn($form)
            ->log('Submitted application form for UUID: ' . $uuid);

        return redirect()
            ->route('form.index', $uuid)
            ->with('success', 'Application form submitted successfully!');
    }
}