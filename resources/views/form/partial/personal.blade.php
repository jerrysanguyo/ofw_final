<div class="mb-4">
    <h6 class="text-muted">Personal na Impormasyon</h6>
    <hr class="my-2">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control"
            value="{{ old('first_name', $userDetails['first_name'] ?? ($userInfo->first_name ?? '')) }}">
        </div>

        <div class="form-group col-md-4">
            <label for="middle_name">Middle Name</label>
            <input type="text" id="middle_name" name="middle_name" class="form-control"
                value="{{ old('middle_name', $userDetails['middle_name'] ?? ($userInfo->middle_name ?? '')) }}">
        </div>

        <div class="form-group col-md-4">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control"
                value="{{ old('last_name', $userDetails['last_name'] ?? ($userInfo->last_name ?? '')) }}">
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="house_number">House no.</label>
            <input type="text" id="house_number" name="house_number" class="form-control"
                value="{{ old('house_number', $userInfo->house_number ?? '') }}">
        </div>

        <div class="form-group col-md-2">
            <label for="street">Street</label>
            <input type="text" id="street" name="street" class="form-control" value="{{ old('street', $userInfo->street ?? '') }}">
        </div>

        <div class="form-group col-md-3">
            <label for="barangay">Barangay</label>
            <select id="barangay" name="barangay" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @foreach ($barangays as $brgy)
                <option value="{{ $brgy->id }}"
                    {{ (string) old('barangay', $userInfo->barangay_id ?? '') === (string) $brgy->id ? 'selected' : '' }}>
                    {{ $brgy->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-2">
            <label for="city">City</label>
            <input type="text" id="city" name="city" class="form-control" value="Taguig City" readonly>
        </div>

        <div class="form-group col-md-2">
            <label for="years_resident">Years of residence in Taguig</label>
            <input type="number" id="years_resident" name="years_resident" class="form-control"
                value="{{ old('years_resident', $userInfo->years_resident ?? '') }}">
        </div>

        <div class="form-group col-md-2">
            <label for="residence_type">Residence type</label>
            <select id="residence_type" name="residence_type" class="form-control" required>
                <option value="" disabled selected hidden>Choose...</option>
                @foreach ($residence_types as $rt)
                <option value="{{ $rt->id }}"
                    {{ (string) old('residence_type', $userInfo->residence_type_id ?? '') === (string) $rt->id ? 'selected' : '' }}>
                    {{ $rt->name }}
                </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="birthdate">Birthdate</label>
            <input type="date" id="birthdate" name="birthdate" class="form-control"
                value="{{ old('birthdate', $userInfo->date_of_birth ?? '') }}">
        </div>

        <div class="form-group col-md-2">
            <label for="age">Age</label>
            <input type="text" id="age" name="age" class="form-control age-input" readonly value="">
        </div>

        <div class="form-group col-md-2">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @foreach($genders as $gender)
                <option value="{{ $gender->id }}"
                    {{ (string) old('gender', $userInfo->gender_id ?? '') === (string) $gender->id ? 'selected' : '' }}>
                    {{ $gender->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-2">
            <label for="place_of_birth">Place of birth</label>
            <input type="text" id="place_of_birth" name="place_of_birth" class="form-control"
                value="{{ old('place_of_birth', $userInfo->place_of_birth ?? '') }}">
        </div>

        <div class="form-group col-md-2">
            <label for="type_id">Valid ID</label>
            <select id="type_id" name="type_id" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @foreach($ids as $validId)
                <option value="{{ $validId->id }}"
                    {{ (string) old('type_id', $userInfo->type_id ?? '') === (string) $validId->id ? 'selected' : '' }}>
                    {{ $validId->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-2">
            <label for="voters">Taguig voter?</label>
            <select id="voters" name="voters" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                <option value="yes" {{ old('voters', $userInfo->voters ?? '') === 'yes' ? 'selected' : '' }}>Yes
                </option>
                <option value="no" {{ old('voters', $userInfo->voters ?? '') === 'no'  ? 'selected' : '' }}>No</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="educational_attainment">Educational attainment</label>
            <select id="educational_attainment" name="educational_attainment" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @php $educationVal = (string) old('educational_attainment', $userInfo->educational_attainment_id ?? ''); @endphp
                @foreach($educations as $education)
                <option value="{{ $education->id }}" {{ $educationVal === (string) $education->id ? 'selected' : '' }}>
                    {{ $education->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="religion">Religion</label>
            <select id="religion" name="religion" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @php $religionVal = (string) old('religion', $userInfo->religion_id ?? ''); @endphp
                @foreach($religions as $religion)
                <option value="{{ $religion->id }}" {{ $religionVal === (string) $religion->id ? 'selected' : '' }}>
                    {{ $religion->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="civil_status">Civil Status</label>
            <select id="civil_status" name="civil_status" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @php $civilVal = (string) old('civil_status', $userInfo->civil_status_id ?? ''); @endphp
                @foreach($civils as $civil)
                <option value="{{ $civil->id }}" {{ $civilVal === (string) $civil->id ? 'selected' : '' }}>
                    {{ $civil->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="present_job">Present job</label>
            <input type="text" id="present_job" name="present_job" class="form-control"
                value="{{ old('present_job', $userInfo->present_job ?? '') }}">
        </div>
    </div>
</div>