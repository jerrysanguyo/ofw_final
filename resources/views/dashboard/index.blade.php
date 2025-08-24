@extends('layouts.dashboard')
@section('content')

<main class="flex-1 p-0 overflow-y-auto">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Home</a></div>
                <div class="breadcrumb-item">Dashboard</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 kpi-card">
                        <div class="card-icon bg-primary kpi-icon">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>No. of OFW</h4>
                            </div>
                            <div class="card-body">
                                <span class="countup" data-target="{{ $totalOfw }}">{{ $totalOfw }}</span>
                            </div>
                            <div class="card-footer pt-0">
                                <small class="text-muted"><i class="fas fa-info-circle mr-1"></i>Total profiles
                                    recorded</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 kpi-card">
                        <div class="card-icon bg-danger kpi-icon">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>No. of landbased</h4>
                            </div>
                            <div class="card-body">
                                <span class="countup" data-target="{{ $landbased }}">{{ $landbased }}</span>
                            </div>
                            <div class="card-footer pt-0">
                                <span class="badge badge-danger">Land</span>
                                <small class="text-muted ml-2">Job type</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 kpi-card">
                        <div class="card-icon bg-warning kpi-icon">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>No. of seabased</h4>
                            </div>
                            <div class="card-body">
                                <span class="countup" data-target="{{ $seabased }}">{{ $seabased }}</span>
                            </div>
                            <div class="card-footer pt-0">
                                <span class="badge badge-warning">Sea</span>
                                <small class="text-muted ml-2">Job type</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 kpi-card">
                        <div class="card-icon bg-success kpi-icon">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>No. of submitted application today</h4>
                            </div>
                            <div class="card-body">
                                <span class="countup" data-target="{{ $submittedToday }}">{{ $submittedToday }}</span>
                            </div>
                            <div class="card-footer pt-0">
                                <small class="text-muted"><i class="far fa-clock mr-1"></i>Today</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('dashboard.partial.countGenerate')
            @include('dashboard.partial.applicantTable')
            @include('dashboard.partial.graph')
        </div>
    </section>
</main>
@push('scripts')
<script>
$(document).ready(function() {
    $('#applicant-table').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 10,
        order: [
            [0, 'desc']
        ],

        dom: '<"d-flex justify-content-between align-items-center mb-3"' +
            '<"dataTables_length"l><"dataTables_filter"f>' +
            '>rt' +
            '<"d-flex justify-content-between align-items-center mt-3"' +
            '<"dataTables_info"i><"dataTables_paginate"p>' +
            '>',
        initComplete() {
            $('div.dataTables_length select')
                .removeClass()
                .addClass('form-select form-select-sm border-bottom');
            $('div.dataTables_filter input')
                .removeClass()
                .addClass('form-control form-control-sm')
                .attr('placeholder', 'Search...');
        },
    });
});
</script>
<script src="{{ asset('assets/js/dashboard/rangeDateApplicant.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/countryCount.js') }}"></script>

<!-- charts js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function() {
    if (!window.chartConfig) {
        const baseColors = [
            'rgba(59, 130, 246, 0.5)',
            'rgba(16, 185, 129, 0.5)', 
            'rgba(234, 179, 8, 0.5)',
            'rgba(239, 68, 68, 0.5)',
            'rgba(168, 85, 247, 0.5)',
            'rgba(14, 165, 233, 0.5)',
            'rgba(244, 114, 182, 0.5)',
            'rgba(34, 197, 94, 0.5)',
            'rgba(250, 204, 21, 0.5)',
            'rgba(99, 102, 241, 0.5)'
        ];
        const baseBorders = baseColors.map(c => c.replace('0.5', '1'));

        window.chartConfig = {
            chartColors: baseColors,
            chartBorderColors: baseBorders,
            generateAdditionalColors: function(n) {
                const additionalColors = [];
                const additionalBorderColors = [];
                for (let i = 0; i < n; i++) {
                    const hue = Math.round((360 / (n + 1)) * (i + 1));
                    const bg = `hsla(${hue}, 70%, 55%, 0.5)`;
                    const brd = `hsla(${hue}, 70%, 40%, 1)`;
                    additionalColors.push(bg);
                    additionalBorderColors.push(brd);
                }
                return {
                    additionalColors,
                    additionalBorderColors
                };
            }
        };
    }
})();
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function createChart(elementId, labels, data, chartType) {
        var el = document.getElementById(elementId);
        if (!el) return null;
        var ctx = el.getContext('2d');

        var config = window.chartConfig || {};
        var colors = (config.chartColors || ['rgba(59,130,246,0.5)']).slice();
        var borderColors = (config.chartBorderColors || ['rgba(59,130,246,1)']).slice();

        if (labels.length > colors.length) {
            var gen = (config.generateAdditionalColors || (n => {
                const additionalColors = [],
                    additionalBorderColors = [];
                for (let i = 0; i < n; i++) {
                    additionalColors.push('rgba(99,102,241,0.5)');
                    additionalBorderColors.push('rgba(99,102,241,1)');
                }
                return {
                    additionalColors,
                    additionalBorderColors
                };
            }))(labels.length - colors.length);

            colors = colors.concat(gen.additionalColors);
            borderColors = borderColors.concat(gen.additionalBorderColors);
        }

        return new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [{
                    label: '',
                    data: data,
                    backgroundColor: colors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            }
        });
    }

    var beneficiaryLabels = @json($distinctBeneficiary -> pluck('age_group'));
    var beneficiaryData = @json($distinctBeneficiary -> pluck('beneficiaryCount'));
    createChart('beneficiaryChart', beneficiaryLabels, beneficiaryData, 'pie');

    var needsLabels = @json($distinctNeeds -> pluck('type_name'));
    var needsData = @json($distinctNeeds -> pluck('needsCount'));
    createChart('needsChart', needsLabels, needsData, 'doughnut');

    var jobTypesLabels = @json($distinctJobTypes -> pluck('job_type'));
    var jobTypesData = @json($distinctJobTypes -> pluck('count'));
    createChart('job_type_chart', jobTypesLabels, jobTypesData, 'bar');
});
</script>
@endpush
@endsection