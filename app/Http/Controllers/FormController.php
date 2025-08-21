<?php

namespace App\Http\Controllers;

use App\Models\CivilStatus;
use App\Models\Contract;
use App\Models\EducationalAttainment;
use App\Models\Gender;
use App\Models\Job;
use App\Models\Need;
use App\Models\Owwa;
use App\Models\Relation;
use App\Models\Religion;
use App\Models\TypeId;
use App\Models\TypeResidence;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
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
        return view('form.index', compact(
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
        ));
    }
}
