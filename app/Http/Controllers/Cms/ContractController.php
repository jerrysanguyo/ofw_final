<?php

namespace App\Http\Controllers\Cms;

use App\Models\Contract;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class ContractController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'contract';
    protected string $table = 'contracts';

    public function __construct()
    {
        $this->cmsService = new CmsService(Contract::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Contracts';
        $resource = $this->resource;
        $columns = ['id', 'name', 'remarks', 'actions'];
        $data = Contract::getAllContracts();

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
    
    public function update(CmsRequest $request, Contract $contract)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $contract->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $contract->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(Contract $contract)
    {
        $destroy = $this->cmsService->cmsDestroy($contract->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}