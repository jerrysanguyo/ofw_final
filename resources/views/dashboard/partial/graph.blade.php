<div class="row">
    <div class="col-12 mb-3">
        <div class="card lift-card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-solid fa-map mr-2 text-success"></i>Geo Graph</h4>
            </div>
            @include('dashboard.partial.charts.geo')
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 mb-3 d-flex">
        <div class="card lift-card flex-fill">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-solid fa-house mr-2 text-warning"></i>Beneficiaries Graph</h4>
            </div>
            <div class="card-body">
                <canvas id="beneficiaryChart" style="width:100%; height:350px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3 d-flex">
        <div class="card lift-card flex-fill">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-solid fa-cart-shopping mr-2" style="color:#a040ba;"></i>Needs Graph</h4>
            </div>
            <div class="card-body">
                <canvas id="needsChart" style="width:100%; height:350px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 mb-3 d-flex">
        <div class="card lift-card flex-fill">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-solid fa-briefcase mr-2" style="color:#d57e1a;"></i>Job Type Graph</h4>
            </div>
            <div class="card-body">
                <canvas id="job_type_chart" style="width:100%; height:350px"></canvas>
            </div>
        </div>
    </div>
</div>
