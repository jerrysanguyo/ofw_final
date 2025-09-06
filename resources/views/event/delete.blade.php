<div class="modal fade" id="deleteModal-{{ $record->id ?? '' }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteModalLabel-{{ $record->id ?? '' }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel-{{ $record->id ?? '' }}">Delete {{ $page_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this {{ Str::lower($page_title) }}?</p>
                <ul class="list-unstyled ml-3">
                    <li><strong>Name:</strong> {{ $record->name ?? '' }}</li>
                    <li><strong>Date & time:</strong> {{ $record->date ?? '' }} - {{ $record->time ?? '' }}</li>
                    <li><strong>Location:</strong> {{ $record->venue ?? '' }} - {{ $record->barangay->name ?? '' }}</li>
                    <li><strong>Status:</strong> {{ $record->status ?? '' }}</li>
                    <li><strong>Remarks:</strong> {{ $record->remarks ?? '' }}</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                <form
                    action="{{ route(Auth::user()->getRoleNames()->first().'.'.$resource.'.destroy', $record->id ?? '') }}"
                    method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>