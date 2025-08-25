<?php

namespace App\Http\Controllers;

use App\DataTables\CmsDataTable;
use App\Http\Requests\ImportRequest;
use App\Models\ArchivePersonal;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ArchiveApplicantsImport;
use Illuminate\Support\Facades\Log;

class ArchiveController extends Controller
{
    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Archive';
        $resource = 'archive';
        $data = ArchivePersonal::getAllArchivePersonals();
        $columns = ['Full name', 'email', 'contact number', 'address', 'action'];
        return $dataTable->render('applicant.index', compact(
            'data',
            'columns',
            'dataTable',
            'resource',
            'page_title',
        ));
    }

    public function import(ImportRequest $request)
    {
        try {
            Excel::import(new ArchiveApplicantsImport, $request->file('import_file'));
            
            activity()
                ->causedBy(auth()->user())
                ->performedOn(new ArchivePersonal)
                ->withProperties([
                    'file' => $request->file('import_file')->getClientOriginalName(),
                    'ip'   => $request->ip(),
                ])
                ->log('Imported archive applicants from Excel file');

            return redirect()
                ->route('superadmin.archive.index')
                ->with('success', 'Import successful.');
        } catch (\Throwable $e) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'file'   => $request->file('import_file')?->getClientOriginalName(),
                    'ip'     => $request->ip(),
                    'error'  => $e->getMessage(),
                ])
                ->log('Failed to import archive applicants');
                
            Log::error('Import failed', [
                'user_id' => auth()->id(),
                'file'    => $request->file('import_file')?->getClientOriginalName(),
                'ip'      => $request->ip(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('superadmin.archive.index')
                ->with('failed', 'Import failed: ' . $e->getMessage());
        }
    }
}