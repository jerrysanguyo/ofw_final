<?php

namespace App\Http\Controllers\Cms;

use App\Models\Owwa;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class OwwaController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'owwa';
    protected string $table = 'owwas';

    public function __construct()
    {
        $this->cmsService = new CmsService(Owwa::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Owwas';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = Owwa::getAllOwwas();

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
    
    public function update(CmsRequest $request, Owwa $owwa)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $owwa->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $owwa->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(Owwa $owwa)
    {
        $destroy = $this->cmsService->cmsDestroy($owwa->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}