@extends('layouts.dashboard')

@section('content')
@include('components.alert')
<section class="section">
    <div class="section-body">
        <div class="card shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    Application form
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route(Auth::user()->getRoleNames()->first() . '.dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fas fa-file-alt"></i> Application form
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="callout callout-info">
                    <div class="callout-header">
                        <i class="fas fa-info-circle text-danger"></i> Please Note
                    </div>
                    <p class="mb-0">
                        For any field that does not apply, simply input <strong>N/A</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="section-body">
        <div class="card shadow-lg card-primary">
            <div class="card-body">
                <form action="" method="post">
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
                                <label for="house_number">House number</label>
                                <input type="text" id="house_number" name="house_number" class="form-control" value="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="barangay">Barangay</label>
                                <select id="barangay" name="barangay" class="form-control">

                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="street">Street</label>
                                <input type="text" id="street" name="street" class="form-control" value="">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="city">City</label>
                                <select id="city" name="city" class="form-control">

                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="residence_years">Years of residence in Taguig</label>
                                <input type="number" id="residence_years" name="residence_years" class="form-control"
                                    value="">
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
                                <input type="text" id="age" name="age" class="form-control age-input" readonly
                                    value="{{ $userInfo->age ?? '' }}">
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
                                    <option value="Yes"
                                        {{ (isset($userInfo) && $userInfo->voters == 'Yes') ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="No"
                                        {{ (isset($userInfo) && $userInfo->voters == 'No')  ? 'selected' : '' }}>No
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

                    <div class="mb-4">
                        <h6 class="text-muted">Impormasyon Noong Huling Nagtrabaho sa Abroad</h6>
                        <hr class="my-2">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="job_type">Job type</label>
                                <select id="job_type" name="job_type" class="form-control">
                                    <option value="" disabled selected hidden>Choose...</option>
                                    <option value="landbase"
                                        {{ isset($previousJob) && $previousJob->job_type == 'landbase' ? 'selected' : '' }}>
                                        Landbased</option>
                                    <option value="seabase"
                                        {{ isset($previousJob) && $previousJob->job_type == 'seabase'  ? 'selected' : '' }}>
                                        Seabased</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="job">Job</label>
                                <select id="job" name="job" class="form-control">
                                    <option value="" disabled selected hidden>Choose...</option>
                                    @foreach($jobs as $job)
                                    <option value="{{ $job->id }}"
                                        {{ isset($previousJob) && $previousJob->job_id == $job->id ? 'selected' : '' }}>
                                        {{ $job->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sub_job">Sub Job</label>
                                <select id="sub_job" name="sub_job" class="form-control">
                                    {{-- populated by JS --}}
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="continent">Continent</label>
                                <select id="continent" name="continent" class="form-control">
                                    <option value="" disabled selected hidden>Choose...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="country">Country</label>
                                <select id="country" name="country" class="form-control">
                                    <option value="" disabled selected hidden>Choose...</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="years_abbroad">Years in abroad</label>
                                <input type="number" id="years_abbroad" name="years_abbroad" class="form-control"
                                    value="{{ $previousJob->years_abbroad ?? '' }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="contract">Status of last Contract</label>
                                <select id="contract" name="contract" class="form-control">
                                    <option value="" disabled selected hidden>Choose...</option>
                                    @foreach($contracts as $contract)
                                    <option value="{{ $contract->id }}"
                                        {{ isset($previousJob) && $previousJob->contract_id == $contract->id ? 'selected' : '' }}>
                                        {{ $contract->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="last_departure">Date of last departure</label>
                                <input type="date" id="last_departure" name="last_departure" class="form-control"
                                    value="{{ $previousJob->last_departure ?? '' }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="last_arrival">Date of last arrival</label>
                                <input type="date" id="last_arrival" name="last_arrival" class="form-control"
                                    value="{{ $previousJob->last_arrival ?? '' }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="owwa">OWWA membership</label>
                                <select id="owwa" name="owwa" class="form-control">
                                    <option value="" disabled selected hidden>Choose...</option>
                                    @foreach($owwas as $owwa)
                                    <option value="{{ $owwa->id }}"
                                        {{ isset($previousJob) && $previousJob->owwa_id == $owwa->id ? 'selected' : '' }}>
                                        {{ $owwa->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="intent_return">Intent to return abroad?</label>
                                <select id="intent_return" name="intent_return" class="form-control">
                                    <option value="yes"
                                        {{ isset($previousJob) && $previousJob->intent_return == 'yes' ? 'selected' : '' }}>
                                        Yes</option>
                                    <option value="no"
                                        {{ isset($previousJob) && $previousJob->intent_return == 'no'  ? 'selected' : '' }}>
                                        No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted">Mga Kasama sa Bahay</h6>
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
                                    <input type="date" name="household[birthdate][]"
                                        class="form-control birthdate-input">
                                </div>
                                <div class="form-group col-lg-1">
                                    <label>Age</label>
                                    <input type="number" name="household[age][]" class="form-control age-input"
                                        readonly>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Work</label>
                                    <input type="text" name="household[work][]" class="form-control">
                                </div>
                                <div class="form-group col-lg-1">
                                    <label>Monthly income</label>
                                    <input type="number" name="household[monthly_income][]" class="form-control"
                                        value="0">
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

                        <div class="d-flex justify-content-end">
                            <button type="button" id="add-household-row" class="btn btn-success mr-2">Add Row</button>
                            <button type="button" id="remove-household-row" class="btn btn-danger">Remove Last
                                Row</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Mga Kailangan ng Pamilya</h6>
                        <hr class="my-2">
                        <div id="needs-container">
                            <div class="form-row mb-2">
                                <div class="form-group col-md-12">
                                    <label for="need_id_0">Need</label>
                                    <select id="need_id_0" name="needs[need_id][]" class="form-control">
                                        @foreach($needs as $need)
                                        <option value="{{ $need->id }}">{{ $need->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="add-need-row" class="btn btn-success mr-2">Add Row</button>
                            <button type="button" id="remove-need-row" class="btn btn-danger">Remove Last Row</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@push('scripts')
@endpush
@endsection