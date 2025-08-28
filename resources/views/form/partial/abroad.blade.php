<div class="mb-4">
    <h6 class="text-muted">Impormasyon Noong Huling Nagtrabaho sa Abroad</h6>
    <hr class="my-2">

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="job_type">Job type</label>
            <select id="job_type" name="job_type" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @php $jobTypeVal = old('job_type', $previousJob->job_type ?? ''); @endphp
                <option value="landbased" {{ $jobTypeVal === 'landbased' ? 'selected' : '' }}>Landbased</option>
                <option value="seabased" {{ $jobTypeVal === 'seabased'  ? 'selected' : '' }}>Seabased</option>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="job">Job</label>
            <select id="job" name="job" class="form-control"
                data-prev-subjob="{{ old('sub_job', $previousJob->sub_job_id ?? '') }}">
                <option value="" disabled selected hidden>Choose...</option>
                @php $jobVal = (string) old('job', $previousJob->job_id ?? ''); @endphp
                @foreach($jobs as $job)
                <option value="{{ $job->id }}" data-name="{{ $job->name }}"
                    {{ $jobVal === (string) $job->id ? 'selected' : '' }}>
                    {{ $job->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="sub_job">Sub Job</label>
            <select id="sub_job" name="sub_job" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                {{-- Populated by JS; selection handled via data-prev-subjob --}}
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="continent">Continent</label>
            <select id="continent" name="continent" class="form-control" data-url="{{ url('/get-countries') }}"
                data-prev-country="{{ old('country', $previousJob->country_id ?? '') }}">
                <option value="" disabled selected hidden>Choose...</option>
                @php $continentVal = (string) old('continent', $previousJob->continent_id ?? ''); @endphp
                @foreach($continents as $continent)
                <option value="{{ $continent->id }}" {{ $continentVal === (string) $continent->id ? 'selected' : '' }}>
                    {{ $continent->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="country">Country</label>
            <select id="country" name="country" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                {{-- Populated by JS and preselected via data-prev-country --}}
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="years_abroad">Years in abroad</label>
            <input type="number" id="years_abroad" name="years_abroad" class="form-control"
                value="{{ old('years_abroad', $previousJob->abroad_years ?? '') }}">
        </div>
        <div class="form-group col-md-2">
            <label for="last_departure">Date of last departure</label>
            <input type="date" id="last_departure" name="last_departure" class="form-control"
                value="{{ old('last_departure', $previousJob->date_departure ?? '') }}">
        </div>
        <div class="form-group col-md-2">
            <label for="last_arrival">Date of last arrival</label>
            <input type="date" id="last_arrival" name="last_arrival" class="form-control"
                value="{{ old('last_arrival', $previousJob->date_arrival ?? '') }}">
        </div>
        <div class="form-group col-md-2">
            <label for="contract">Status of last Contract</label>
            <select id="contract" name="contract" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @php $contractVal = (string) old('contract', $previousJob->contract_id ?? ''); @endphp
                @foreach($contracts as $contract)
                <option value="{{ $contract->id }}" {{ $contractVal === (string) $contract->id ? 'selected' : '' }}>
                    {{ $contract->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="owwa">OWWA membership</label>
            <select id="owwa" name="owwa" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                @php $owwaVal = (string) old('owwa', $previousJob->owwa_id ?? ''); @endphp
                @foreach($owwas as $owwa)
                <option value="{{ $owwa->id }}" {{ $owwaVal === (string) $owwa->id ? 'selected' : '' }}>
                    {{ $owwa->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="intent_return">Intent to return abroad?</label>
            @php $intentVal = old('intent_return', $previousJob->intent_return ?? ''); @endphp
            <select id="intent_return" name="intent_return" class="form-control">
                <option value="" disabled selected hidden>Choose...</option>
                <option value="yes" {{ $intentVal === 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ $intentVal === 'no'  ? 'selected' : '' }}>No</option>
            </select>
        </div>
    </div>
</div>