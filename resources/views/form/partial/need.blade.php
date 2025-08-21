<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h6 class="text-muted mb-0">Mga Kailangan ng Pamilya</h6>
        <div>
            <button type="button" id="add-need-row" class="btn btn-success btn-sm mr-2">+</button>
            <button type="button" id="remove-need-row" class="btn btn-danger btn-sm">−</button>
        </div>
    </div>
    <hr class="my-2">

    <div id="needs-container">
        <div class="form-row mb-2 need-row">
            <div class="form-group col-md-12">
                <label for="need_id_0">Need</label>
                <select id="need_id_0" name="needs[need_id][]" class="form-control need-select">
                    <option value="" selected disabled hidden>Choose...</option>
                    @foreach($needs as $need)
                    <option value="{{ $need->id }}">{{ $need->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>