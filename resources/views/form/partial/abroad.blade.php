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
                <option value="{{ $job->id }}" data-name="{{ $job->name }}"
                    {{ isset($previousJob) && $previousJob->job_id == $job->id ? 'selected' : '' }}>
                    {{ $job->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="sub_job">Sub Job</label>
            <select id="sub_job" name="sub_job" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                {{-- populated by JS --}}
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="continent">Continent</label>
            <select id="continent" name="continent" class="form-control" data-url="{{ url('/get-countries') }}">
                <option value="" disabled selected hidden>Choose...</option>
                @foreach($continents as $continent)
                <option value="{{ $continent->id }}">{{ $continent->name }}</option>
                @endforeach
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
                <option value="yes" {{ isset($previousJob) && $previousJob->intent_return == 'yes' ? 'selected' : '' }}>
                    Yes</option>
                <option value="no" {{ isset($previousJob) && $previousJob->intent_return == 'no'  ? 'selected' : '' }}>
                    No</option>
            </select>
        </div>
    </div>
</div>