<div class="mb-4">
    <h6 class="text-muted">Personal na Impormasyon</h6>
    <hr class="my-2">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="fullname">Full name</label>
            <input type="text" id="fullname" name="fullname" class="form-control" value="">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="house_number">House no.</label>
            <input type="text" id="house_number" name="house_number" class="form-control" value="">
        </div>
        <div class="form-group col-md-2">
            <label for="street">Street</label>
            <input type="text" id="street" name="street" class="form-control" value="">
        </div>
        <div class="form-group col-md-3">
            <label for="barangay">Barangay</label>
            <select id="barangay" name="barangay" class="form-control">

            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="city">City</label>
            <input type="text" id="city" name="city" class="form-control" value="Taguig City" readonly disabled>
        </div>
        <div class="form-group col-md-2">
            <label for="residence_years">Years of residence in Taguig</label>
            <input type="number" id="residence_years" name="residence_years" class="form-control" value="">
        </div>
        <div class="form-group col-md-2">
            <label for="residence_type">Residence type</label>
            <select id="residence_type" name="residence_type" class="form-control" required>
                <option value="" disabled selected hidden>Choose...</option>
                @foreach ($residence_types as $rt)
                <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="birthdate">Birthdate</label>
            <input type="date" id="birthdate" name="birthdate" class="form-control birthdate-input"
                value="{{ $userInfo->birthdate ?? '' }}">
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
                    {{ (isset($userInfo) && $userInfo->gender_id == $gender->id) ? 'selected' : '' }}>
                    {{ $gender->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="birthplace">Place of birth</label>
            <input type="text" id="birthplace" name="birthplace" class="form-control"
                value="{{ $userInfo->birthplace ?? '' }}">
        </div>
        <div class="form-group col-md-2">
            <label for="valid_id">Valid ID</label>
            <select id="valid_id" name="valid_id" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @foreach($ids as $validId)
                <option value="{{ $validId->id }}"
                    {{ (isset($userInfo) && $userInfo->valid_id == $validId->id) ? 'selected' : '' }}>
                    {{ $validId->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="voters">Taguig voter?</label>
            <select id="voters" name="voters" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                <option value="Yes" {{ (isset($userInfo) && $userInfo->voters == 'Yes') ? 'selected' : '' }}>Yes
                </option>
                <option value="No" {{ (isset($userInfo) && $userInfo->voters == 'No')  ? 'selected' : '' }}>No
                </option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="education">Educational attainment</label>
            <select id="education" name="education" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @foreach($educations as $education)
                <option value="{{ $education->id }}"
                    {{ (isset($userInfo) && $userInfo->education_id == $education->id) ? 'selected' : '' }}>
                    {{ $education->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="religion">Religion</label>
            <select id="religion" name="religion" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @foreach($religions as $religion)
                <option value="{{ $religion->id }}"
                    {{ (isset($userInfo) && $userInfo->religion_id == $religion->id) ? 'selected' : '' }}>
                    {{ $religion->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="civil">Civil Status</label>
            <select id="civil" name="civil" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @foreach($civils as $civil)
                <option value="{{ $civil->id }}"
                    {{ (isset($userInfo) && $userInfo->civil_id == $civil->id) ? 'selected' : '' }}>
                    {{ $civil->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="present_job">Present job</label>
            <input type="text" id="present_job" name="present_job" class="form-control"
                value="{{ $userInfo->present_job ?? '' }}">
        </div>
    </div>
</div>