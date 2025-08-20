<?php

namespace App\Http\Controllers\Cms;

use App\Models\Religion;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class ReligionController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'religion';
    protected string $table = 'religions';

    public function __construct()
    {
        $this->cmsService = new CmsService(Religion::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Religions';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = Religion::getAllReligions();

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
    
    public function update(CmsRequest $request, Religion $religion)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $religion->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $religion->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(Religion $religion)
    {
        $destroy = $this->cmsService->cmsDestroy($religion->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}