<?php

namespace App\Http\Controllers\Cms;

use App\Models\Barangay;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class BarangayController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'barangay';
    protected string $table = 'barangays';

    public function __construct()
    {
        $this->cmsService = new CmsService(Barangay::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Barangays';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = Barangay::getAllBarangays();

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
    
    public function update(CmsRequest $request, Barangay $barangay)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $barangay->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $barangay->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(Barangay $barangay)
    {
        $destroy = $this->cmsService->cmsDestroy($barangay->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}