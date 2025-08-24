@extends('layouts.dashboard')
@section('content')

<main class="flex-1 p-0 overflow-y-auto">
    <section class="section">
        <div class="section-body">
            <div class="card shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">
                        Report
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route(Auth::user()->getRoleNames()->first() . '.dashboard') }}">
                                    <i class="fas fa-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-file-alt"></i> Report
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card card-primary shadow">
                        <div class="card-header">
                            <h4><i class="fas fa-user-clock mr-2"></i> Age Report</h4>
                        </div>
                        <div class="card-body">
                            <form id="ageForm"
                                action="{{ route(Auth::user()->getRoleNames()->first() . '.age.export') }}"
                                method="GET">
                                @csrf
                                <div class="form-group">
                                    <label for="ageBracket">Age Bracket</label>
                                    <select name="ageBracket" id="ageBracket" class="form-control selectric">
                                        <option value="0-10" {{ ($defaultBracket ?? '') === '0-10' ? 'selected' : '' }}>
                                            0–10 years old</option>
                                        <option value="11-20"
                                            {{ ($defaultBracket ?? '') === '11-20' ? 'selected' : '' }}>11–20 years old
                                        </option>
                                        <option value="21-99"
                                            {{ ($defaultBracket ?? '') === '21-99' ? 'selected' : '' }}>21 & above
                                        </option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" id="submitBtn" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Submit
                                    </button>
                                    <button type="submit" id="excelBtn" class="btn btn-success">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </button>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <span id="AgeCount"
                                        class="display-4 font-weight-bold">{{ $defaultAgeCount ?? '' }}</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card card-success shadow">
                        <div class="card-header">
                            <h4><i class="fas fa-flag mr-2"></i> Country Report</h4>
                        </div>
                        <div class="card-body">
                            <form id="countryForm" action="{{ route(Auth::user()->getRoleNames()->first() . '.country.export') }}" method="GET">
                                @csrf
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select name="country" id="country" class="form-control selectric">
                                        @foreach($listOfCountry as $country)
                                        <option value="{{ $country->id }}"
                                            {{ (isset($defaultCountryId) && $defaultCountryId == $country->id) ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" id="countrySubmitBtn" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Submit
                                    </button>
                                    <button type="submit" id="countryExcelBtn" class="btn btn-success">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </button>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <span id="countryCount" class="display-4 font-weight-bold">
                                        {{ $defaultCountryCount ?? '' }}
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="card card-secondary shadow">
                        <div class="card-header">
                            <h4><i class="fas fa-chart-bar mr-2"></i> Coming Soon</h4>
                        </div>
                        <div class="card-body text-center text-muted">
                            <em>Report placeholder</em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@push('scripts')
<script>
(function() {
    const bracketEl = document.getElementById('ageBracket');
    const submitBtn = document.getElementById('submitBtn');
    const countEl = document.getElementById('AgeCount');

    async function fetchCount() {
        const url = "{{ route(Auth::user()->getRoleNames()->first() . '.age.count') }}" + "?ageBracket=" +
            encodeURIComponent(bracketEl.value);
        submitBtn.disabled = true;
        const prev = countEl.textContent;
        countEl.textContent = '...';
        try {
            const res = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!res.ok) throw new Error('Request failed');
            const data = await res.json();
            countEl.textContent = data.count ?? 0;
        } catch (e) {
            console.error(e);
            countEl.textContent = prev || '—';
        } finally {
            submitBtn.disabled = false;
        }
    }
    submitBtn.addEventListener('click', fetchCount);
})();
</script>
<script>
(function() {
    const selectEl = document.getElementById('country');
    const submitBtn = document.getElementById('countrySubmitBtn');
    const countEl = document.getElementById('countryCount');

    async function fetchCountryCount() {
        const url = "{{ route(Auth::user()->getRoleNames()->first() . '.country.count') }}" + "?country=" + encodeURIComponent(selectEl.value);
        submitBtn.disabled = true;
        const prev = countEl.textContent;
        countEl.textContent = '...';
        try {
            const res = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!res.ok) throw new Error('Request failed');
            const data = await res.json();
            countEl.textContent = data.count ?? 0;
        } catch (e) {
            console.error(e);
            countEl.textContent = prev || '—';
        } finally {
            submitBtn.disabled = false;
        }
    }

    submitBtn.addEventListener('click', fetchCountryCount);
})();
</script>
@endpush
@endsection