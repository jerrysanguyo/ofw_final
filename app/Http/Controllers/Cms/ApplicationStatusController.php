<?php

namespace App\Http\Controllers\Cms;

use App\Models\ApplicationStatus;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class ApplicationStatusController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'status';
    protected string $table = 'application_status';

    public function __construct()
    {
        $this->cmsService = new CmsService(ApplicationStatus::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Application Status';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = ApplicationStatus::getAllApplicationStatuses();

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
    
    public function update(CmsRequest $request, ApplicationStatus $status)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $status->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $status->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(ApplicationStatus $status)
    {
        $destroy = $this->cmsService->cmsDestroy($status->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}