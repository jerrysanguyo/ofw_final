<?php

namespace App\Http\Controllers\Cms;

use App\Models\Job;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class JobController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'job';
    protected string $table = 'jobs';

    public function __construct()
    {
        $this->cmsService = new CmsService(Job::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Jobs';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = Job::getAllJobs();

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
    
    public function update(CmsRequest $request, Job $job)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $job->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $job->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(Job $job)
    {
        $destroy = $this->cmsService->cmsDestroy($job->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}