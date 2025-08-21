<?php

namespace App\Http\Controllers\Cms;

use App\Models\TypeId;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class TypeIdController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'typeId';
    protected string $table = 'type_ids';

    public function __construct()
    {
        $this->cmsService = new CmsService(TypeId::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'ID';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = TypeId::getAllTypeIds();

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
    
    public function update(CmsRequest $request, TypeId $typeId)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $typeId->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $typeId->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(TypeId $typeId)
    {
        $destroy = $this->cmsService->cmsDestroy($typeId->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}