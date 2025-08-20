<?php

namespace App\Http\Controllers\Cms;

use App\Models\CivilStatus;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class CivilStatusController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'civil';
    protected string $table = 'civil';

    public function __construct()
    {
        $this->cmsService = new CmsService(CivilStatus::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Civil Status';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = CivilStatus::getAllCivilStatuses();

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
    
    public function update(CmsRequest $request, CivilStatus $civil)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $civil->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $civil->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(CivilStatus $civil)
    {
        $destroy = $this->cmsService->cmsDestroy($civil->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}