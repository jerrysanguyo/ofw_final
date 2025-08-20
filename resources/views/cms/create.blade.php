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
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control"
                            placeholder="Enter {{ $page_title }} name" required>
                    </div>

                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <input type="text" id="remarks" name="remarks" class="form-control" placeholder="Enter remarks"
                            required>
                    </div>

                    @php
                    $foreignKeyMap = [
                    'barangay' => 'district_id',
                    'goal' => 'domain_id',
                    'competency' => 'domain_id',
                    'objective' => 'goal_id',
                    ];
                    $field = $foreignKeyMap[$resource] ?? null;
                    @endphp

                    @if($field)
                    <div class="form-group">
                        <label for="{{ $field }}">
                            {{ Str::title(str_replace('_',' ',$field)) }}
                        </label>
                        <select id="{{ $field }}" name="{{ $field }}" class="form-control">
                            @foreach($subRecords as $item)
                            <option value="{{ $item->id }}" {{ old($field) == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
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