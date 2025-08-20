<div class="modal fade" id="editModal-{{ $record->id ?? '' }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel-{{ $record->id ?? '' }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel-{{ $record->id ?? '' }}">Edit {{ $page_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route(Auth::user()->getRoleNames()->first().'.'.$resource.'.update', $record->id ?? '') }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name-{{ $record->id ?? '' }}">{{ $page_title }} Name</label>
                        <input type="text" id="name-{{ $record->id ?? '' }}" name="name" class="form-control"
                            value="{{ old('name', $record->name ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="remarks-{{ $record->id ?? '' }}">Remarks</label>
                        <input type="text" id="remarks-{{ $record->id ?? '' }}" name="remarks" class="form-control"
                            value="{{ old('remarks', $record->remarks ?? '') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>