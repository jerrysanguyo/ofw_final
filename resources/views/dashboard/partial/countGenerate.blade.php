<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-statistic-2 lift-card">
            <div class="card-header d-block pb-0">
                <h4 class="mb-1">
                    <i class="fa-solid fa-suitcase mr-2 text-primary"></i>Total Applicant
                </h4>
                <p class="text-muted mb-0 small">Filter by date range and generate the total count.</p>
            </div>

            <div class="card-body">
                <form id="applicantCountForm"
                    action="{{ route(Auth::user()->getRoleNames()->first() . '.dashboard.applicant.count') }}"
                    method="POST" class="mb-0">
                    @csrf
                    <div class="row align-items-end mt-1">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="startDate" class="form-label">Start date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar"></i></span>
                                </div>
                                <input type="date" id="startDate" name="startDate" class="form-control"
                                    placeholder="YYYY-MM-DD">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="endDate" class="form-label">End date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" id="endDate" name="endDate" class="form-control"
                                    placeholder="YYYY-MM-DD">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" id="applicantCountBtn" class="btn btn-primary btn-block mt-4 mt-md-0">
                                <span class="btn-label">
                                    <i class="fas fa-sync-alt mr-1"></i> Generate
                                </span>
                                <span class="btn-spinner d-none">
                                    <i class="fas fa-circle-notch fa-spin mr-2"></i> Processing…
                                </span>
                            </button>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="text-center">
                    <h2 id="applicantCount" class="font-weight-bold mb-2">—</h2>
                    <small id="applicantCountMeta" class="text-muted d-block"></small>

                    <noscript>
                        <div class="alert alert-warning mt-3 mb-0">
                            Enable JavaScript to see the result without leaving this page.
                        </div>
                    </noscript>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card card-statistic-2 lift-card">
            <div class="card-header d-block pb-0">
                <h4 class="mb-1">
                    <i class="fa-solid fa-globe mr-2 text-info"></i>OFW per Continent
                </h4>
                <p class="text-muted mb-0 small">See total and country breakdown</p>
            </div>

            <div class="card-body">
                <form id="continentForm"
                    action="{{ route(Auth::user()->getRoleNames()->first() . '.dashboard.continent.breakdown') }}"
                    method="POST" class="mb-0">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <label for="continent" class="form-label">Continent</label>
                            <select name="continent_id" id="continent" class="form-control">
                                @foreach($listOfContinent as $continent)
                                <option value="{{ $continent->id }}">{{ $continent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="countroCountBtn" class="btn btn-primary btn-block mt-4 mt-md-0">
                                <span class="btn-label"><i class="fas fa-chart-pie mr-1"></i> Generate</span>
                                <span class="btn-spinner d-none"><i class="fas fa-circle-notch fa-spin mr-2"></i>
                                    Processing…</span>
                            </button>
                        </div>
                    </div>
                </form>

                <hr>

                <h2 id="countroCount" class="text-center font-weight-bold mb-2">—</h2>
                <ul id="countryList" class="list-unstyled text-center small mb-0"></ul>
            </div>
        </div>
    </div>
</div>