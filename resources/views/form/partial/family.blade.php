<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="text-muted mb-0">Mga Kasama sa Bahay</h6>
        <div>
            <button type="button" id="add-household-row" class="btn btn-success btn-sm mr-2">+</button>
            <button type="button" id="remove-household-row" class="btn btn-danger btn-sm">−</button>
        </div>
    </div>
    <hr class="my-2">
    <div id="household-container">
        <div class="form-row household-row">
            <div class="form-group col-lg-3">
                <label>Full name</label>
                <input type="text" name="household[full_name][]" class="form-control">
            </div>
            <div class="form-group col-lg-1">
                <label>Relationship</label>
                <select name="household[relation_id][]" class="form-control">
                    <option value="" disabled selected hidden>Choose...</option>
                    @foreach($relations as $relation)
                    <option value="{{ $relation->id }}">{{ $relation->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-2">
                <label>Birthdate</label>
                <input type="date" name="household[birthdate][]" class="form-control birthdate-input">
            </div>
            <div class="form-group col-lg-1">
                <label>Age</label>
                <input type="number" name="household[age][]" class="form-control age-input" readonly>
            </div>
            <div class="form-group col-lg-3">
                <label>Work</label>
                <input type="text" name="household[work][]" class="form-control">
            </div>
            <div class="form-group col-lg-1">
                <label>Monthly income</label>
                <input type="number" name="household[monthly_income][]" class="form-control" value="0">
            </div>
            <div class="form-group col-lg-1">
                <label>Voter?</label>
                <select name="household[voters][]" class="form-control voters-select">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>
    </div>
</div>