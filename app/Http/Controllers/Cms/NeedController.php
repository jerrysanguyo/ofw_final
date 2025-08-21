<?php

namespace App\Http\Controllers\Cms;

use App\Models\Need;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class NeedController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'need';
    protected string $table = 'needs';

    public function __construct()
    {
        $this->cmsService = new CmsService(Need::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Needs';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = Need::getAllNeeds();

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
    
    public function update(CmsRequest $request, Need $need)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $need->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $need->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(Need $need)
    {
        $destroy = $this->cmsService->cmsDestroy($need->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}