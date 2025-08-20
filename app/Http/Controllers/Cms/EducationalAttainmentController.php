<?php

namespace App\Http\Controllers\Cms;

use App\Models\EducationalAttainment;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class EducationalAttainmentController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'educational';
    protected string $table = 'educational_attainments';

    public function __construct()
    {
        $this->cmsService = new CmsService(EducationalAttainment::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Educational Attainments';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = EducationalAttainment::getAllEducationalAttainments();

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
    
    public function update(CmsRequest $request, EducationalAttainment $educational)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $educational->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $educational->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(EducationalAttainment $educational)
    {
        $destroy = $this->cmsService->cmsDestroy($educational->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}