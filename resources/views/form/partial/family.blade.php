<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="text-muted mb-0">Mga Kasama sa Bahay</h6>
        <div>
            <button type="button" id="add-household-row" class="btn btn-success btn-sm mr-2">+</button>
            <button type="button" id="remove-household-row" class="btn btn-danger btn-sm">−</button>
        </div>
    </div>
    <hr class="my-2">

    @php
    $householdsArr = collect($households ?? [])->values()->all();

    $oldHouse = old('household', []);
    $oldCount = max(
    count($oldHouse['full_name'] ?? []),
    count($oldHouse['relation_id'] ?? []),
    count($oldHouse['birthdate'] ?? []),
    count($oldHouse['age'] ?? []),
    count($oldHouse['work'] ?? []),
    count($oldHouse['monthly_income'] ?? []),
    count($oldHouse['voters'] ?? [])
    );

    $dbCount = count($householdsArr);
    $rows = max($oldCount, $dbCount, 1);
    @endphp

    <div id="household-container">
        @for ($i = 0; $i < $rows; $i++) 
            @php
                $fam = $householdsArr[$i] ?? null;

                $db_full_name   = $fam->full_name   ?? ''; 
                $db_relation_id = $fam->relation_id ?? null;
                $db_birthdate   = $fam->date_of_birth ?? null;
                $db_age         = isset($fam->date_of_birth) ? \Carbon\Carbon::parse($fam->date_of_birth)->age : null;
                $db_work        = $fam->work        ?? '';
                $db_income      = $fam->income      ?? 0;
                $db_voters      = $fam->voters      ?? null;

                $val_full_name   = old("household.full_name.$i", $db_full_name);
                $val_relation_id = old("household.relation_id.$i", $db_relation_id);
                $val_birthdate   = old("household.birthdate.$i", $db_birthdate);
                $val_age         = old("household.age.$i", $db_age);
                $val_work        = old("household.work.$i", $db_work);
                $val_income      = old("household.monthly_income.$i", $db_income);
                $val_voters      = old("household.voters.$i", $db_voters);
            @endphp

            <div class="form-row household-row">
                <div class="form-group col-lg-3">
                    <label>Full name</label>
                    <input type="text" name="household[full_name][]" class="form-control" value="{{ $val_full_name }}">
                </div>

                <div class="form-group col-lg-1">
                    <label>Relationship</label>
                    <select name="household[relation_id][]" class="form-control">
                        <option value="" disabled hidden {{ $val_relation_id === null ? 'selected' : '' }}>
                            Choose...
                        </option>
                        @foreach($relations as $relation)
                        <option value="{{ $relation->id }}"
                            {{ (string)$val_relation_id === (string)$relation->id ? 'selected' : '' }}>
                            {{ $relation->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-2">
                    <label>Birthdate</label>
                    <input type="date" name="household[birthdate][]" class="form-control birthdate-input"
                        value="{{ $val_birthdate }}">
                </div>

                <div class="form-group col-lg-1">
                    <label>Age</label>
                    <input type="number" name="household[age][]" class="form-control age-input" readonly
                        value="{{ $val_age }}">
                </div>

                <div class="form-group col-lg-3">
                    <label>Work</label>
                    <input type="text" name="household[work][]" class="form-control" value="{{ $val_work }}">
                </div>

                <div class="form-group col-lg-1">
                    <label>Income</label>
                    <input type="number" name="household[monthly_income][]" class="form-control"
                        value="{{ $val_income }}">
                </div>

                <div class="form-group col-lg-1">
                    <label>Voter?</label>
                    <select name="household[voters][]" class="form-control voters-select">
                        <option value="" disabled hidden {{ $val_voters === null ? 'selected' : '' }}>Choose...</option>
                        <option value="yes" {{ $val_voters === 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ $val_voters === 'no'  ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>
            @endfor
    </div>
</div>