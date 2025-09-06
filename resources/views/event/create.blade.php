<div class="modal fade" id="add{{ $resource }}Modal" tabindex="-1" role="dialog"
    aria-labelledby="add{{ $resource }}ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add{{ $resource }}ModalLabel">
                    Add New {{ $page_title }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route(Auth::user()->getRoleNames()->first().'.'.$resource.'.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Event name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Enter event name"
                                    value="{{ old('event_name') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="venue">Venue</label>
                                <input type="text" id="venue" name="venue" class="form-control"
                                    placeholder="Enter venue" value="{{ old('event_name') }}"
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
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="date">Date of event</label>
                                <input type="date" id="date" name="date" class="form-control"
                                    value="{{ old('event_name') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="time">Time of event</label>
                                <input type="text" id="time" name="time" class="form-control" placeholder="Enter time"
                                    value="{{ old('event_name') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <input type="text" id="remarks" name="remarks" class="form-control"
                                    placeholder="Enter remarks" value="{{ old('event_name') }}"
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