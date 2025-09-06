<div class="modal fade" id="editModal-{{ $record->id ?? '' }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel-{{ $record->id ?? '' }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit{{ $resource }}ModalLabel">
                    Add New {{ $page_title }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route(Auth::user()->getRoleNames()->first().'.'.$resource.'.update', $record->id) }}"
                method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Event name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Enter event name" value="{{ old('name', $record->name ?? '') }}"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="venue">Venue</label>
                                <input type="text" id="venue" name="venue" class="form-control"
                                    placeholder="Enter venue" value="{{ old('event_name', $record->venue ?? '') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="barangay">Barangay</label>
                                <select id="barangay" name="barangay" class="form-control">
                                    @foreach($subRecords as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('barangay') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="date">Date of event</label>
                                <input type="date" id="date" name="date" class="form-control"
                                    value="{{ old('event_name', $record->date ?? '') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="time">Time of event</label>
                                <input type="text" id="time" name="time" class="form-control" placeholder="Enter time"
                                    value="{{ old('event_name', $record->time ?? '') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="created"
                                        {{ old('status', $record->status) == 'created'  ? 'selected' : '' }}>Created
                                    </option>
                                    <option value="ongoing"
                                        {{ old('status', $record->status) == 'ongoing'  ? 'selected' : '' }}>On-going
                                    </option>
                                    <option value="done"
                                        {{ old('status', $record->status) == 'done'  ? 'selected' : '' }}>Done
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <input type="text" id="remarks" name="remarks" class="form-control"
                                    placeholder="Enter remarks" value="{{ old('event_name', $record->remarks ?? '') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>