<div class="modal fade" id="add{{ $resource }}Modal" tabindex="-1" role="dialog"
    aria-labelledby="add{{ $resource }}ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add{{ $resource }}ModalLabel">
                    Import {{ $page_title }} (Excel)
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route(Auth::user()->getRoleNames()->first() . '.archives.import') }}" method="POST" enctype="multipart/form-data"
                id="excel-import-form">
                @csrf

                <div class="modal-body">
                    <div class="alert alert-info d-flex align-items-start">
                        <i class="fas fa-info-circle mr-2 mt-1"></i>
                        <div>
                            Upload an <strong>.xlsx</strong>, <strong>.xls</strong>, or <strong>.csv</strong> file.
                            The first row should contain column headers.
                            @isset($templateUrl)
                            You may use this template:
                            <a href="{{ $templateUrl }}" target="_blank">Download sample</a>.
                            @endisset
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="import_file">Excel File</label>
                        <input type="file" id="import_file" name="import_file"
                            class="form-control @error('import_file') is-invalid @enderror" accept=".xlsx,.xls,.csv"
                            required>
                        @error('import_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Max 20MB. Make sure headers match the expected columns.
                        </small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="import-submit-btn">
                        <i class="fas fa-file-upload mr-1"></i>
                        <span class="label-text">Upload & Import</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('excel-import-form')?.addEventListener('submit', function(e) {
    const btn = document.getElementById('import-submit-btn');
    btn.disabled = true;
    btn.querySelector('.label-text').textContent = 'Importing...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
});
</script>
@endpush