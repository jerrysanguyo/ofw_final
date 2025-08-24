<?php

namespace App\Http\Controllers;

use App\DataTables\CmsDataTable;
use App\Models\UserPersonal;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Applicants';
        $resource = 'applicant';
        $data = UserPersonal::getAllUserPersonals();
        $columns = ['Full name', 'email', 'contact number', 'address', 'action'];
        return $dataTable->render('applicant.index', compact(
            'data',
            'columns',
            'dataTable',
            'resource',
            'page_title',
        ));
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
