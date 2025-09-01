<?php

namespace App\Http\Controllers;

use App\DataTables\CmsDataTable;
use App\Models\ApplicationStatus;
use App\Models\UserPersonal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicantController extends Controller
{
    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Applicants';
        $resource = 'applicant';
        $data = UserPersonal::getAllUserPersonals();
        $columns = ['Full name', 'email', 'contact number', 'address', 'status', 'action'];
        return $dataTable->render('applicant.index', compact(
            'data',
            'columns',
            'dataTable',
            'resource',
            'page_title',
        ));
    }

    
    public function set(UserPersonal $userPersonal, Request $request)
    {
        $data = $request->validate([
            'status'  => ['required', Rule::in(['approved','pending'])],
            'remarks' => ['nullable','string','max:500'],
        ]);

        $status = ApplicationStatus::firstOrCreate(['name' => $data['status']]);

        $userPersonal->update(['status_id' => $status->id]);

        return response()->json([
            'status_id'    => $status->id,
            'status'       => $status->name,
            'status_label' => ucfirst($status->name),
        ]);
    }
    
    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
        //
    }
    
    public function show(UserPersonal $userPersonal)
    {
        //
    }
    
    public function edit(UserPersonal $userPersonal)
    {
        //
    }
    
    public function update(Request $request, UserPersonal $userPersonal)
    {
        //
    }
    
    public function destroy(UserPersonal $userPersonal)
    {
        //
    }
}
