<?php

namespace App\Http\Controllers\Cms;

use App\Models\SubJob;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class SubJobController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'SubJob';
    protected string $table = 'SubJobs';

    public function __construct()
    {
        $this->cmsService = new CmsService(SubJob::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'SubJobs';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = SubJob::getAllSubJobs();

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
    
    public function update(CmsRequest $request, SubJob $subJob)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $subJob->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $subJob->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(SubJob $subJob)
    {
        $destroy = $this->cmsService->cmsDestroy($subJob->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}