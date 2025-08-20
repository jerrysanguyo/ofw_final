<?php

namespace App\Http\Controllers\Cms;

use App\Models\TypeResidence;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class TypeResidenceController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'residence';
    protected string $table = 'type_residences';

    public function __construct()
    {
        $this->cmsService = new CmsService(TypeResidence::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Type of Residence';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = TypeResidence::getAllTypeResidences();

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
    
    public function update(CmsRequest $request, TypeResidence $residence)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $residence->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $residence->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(TypeResidence $residence)
    {
        $destroy = $this->cmsService->cmsDestroy($residence->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}