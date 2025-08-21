<?php

namespace App\Http\Controllers\Cms;

use App\Models\Continent;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class ContinentController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'continent';
    protected string $table = 'continents';

    public function __construct()
    {
        $this->cmsService = new CmsService(Continent::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Continents';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = Continent::getAllContinents();

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
    
    public function update(CmsRequest $request, Continent $continent)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $continent->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $continent->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(Continent $continent)
    {
        $destroy = $this->cmsService->cmsDestroy($continent->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}