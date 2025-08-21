<?php

namespace App\Http\Controllers\Cms;

use App\Models\Continent;
use App\Models\Country;
use App\Http\Requests\CmsRequest;
use App\DataTables\CmsDataTable;
use App\Services\CmsService;
use App\Http\Controllers\Controller;


class CountryController extends Controller
{
    protected CmsService $cmsService;
    protected string $resource = 'country';
    protected string $table = 'countries';

    public function __construct()
    {
        $this->cmsService = new CmsService(Country::class);
    }

    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Countries';
        $resource = $this->resource;
        $columns = ['id', 'name', 'continent', 'remarks', 'actions'];
        $data = Country::getAllCountries();
        $subRecords = Continent::getAllContinents();

        return $dataTable
            ->render('cms.index', compact(
                'page_title',
                'resource',
                'columns',
                'data',
                'dataTable',
                'subRecords',
            ));
    }
    
    public function store(CmsRequest $request)
    {
        $request->merge(['cms_table' => $this->table]);
        $store = $this->cmsService->cmsStore($request->validated());

        return $this->cmsService->handleRedirect($store, $this->resource, 'created');
    }
    
    public function update(CmsRequest $request, Country $country)
    {
        $request->merge(['cms_table' => $this->table, 'id' => $country->id]);
        $update = $this->cmsService->cmsUpdate($request->validated(), $country->id);

        return $this->cmsService->handleRedirect($update, $this->resource, 'updated');
    }
    
    public function destroy(Country $country)
    {
        $destroy = $this->cmsService->cmsDestroy($country->id);

        return $this->cmsService->handleRedirect($destroy, $this->resource, 'deleted');
    }
}