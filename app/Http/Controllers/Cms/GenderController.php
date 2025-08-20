<?php

namespace App\Http\Controllers\Cms;

use App\Models\Gender;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class GenderController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'gender';
    protected string $table = 'genders';

    public function __construct()
    {
        $this->cmsService = new CmsService(Gender::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Genders';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = Gender::getAllGenders();

        return $dataTable
            ->render('cms.index', compact(
                'page_title',
                'resource',
                'columns',
                'data',
                'dataTable',
            ));
    }
    
    public function store(CmsRequest $request)
    {
        $request->merge(['cms_table' => $this->table]);
        $store = $this->cmsService->cmsStore($request->validated());

        return $this->cmsService->handleRedirect($store, $this->resource, 'created');
    }
    
    public function update(CmsRequest $request, Gender $gender)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $gender->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $gender->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(Gender $gender)
    {
        $destroy = $this->cmsService->cmsDestroy($gender->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}