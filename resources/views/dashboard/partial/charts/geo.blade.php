<div class="card-body">
    <div id="regions_div" style="width:100%; height:420px;"></div>
</div>

@push('scripts')
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
(function() {
    google.charts.load('current', {
        packages: ['geochart']
    });
    google.charts.setOnLoadCallback(drawRegionsMap);

    const rawData = {!!$chartDataJson!!};

    function drawRegionsMap() {
        if (!document.getElementById('regions_div')) return;
        const data = google.visualization.arrayToDataTable(rawData);

        const options = {
            backgroundColor: 'transparent',
            datalessRegionColor: '#f1f3f4',
            defaultColor: '#9aa0a6',
            colorAxis: {
                colors: ['#e7711c', '#4374e0']
            }
        };

        const chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        chart.draw(data, options);
    }

    // Redraw on resize
    let t;
    window.addEventListener('resize', function() {
        clearTimeout(t);
        t = setTimeout(drawRegionsMap, 200);
    });
})();
</script>
@endpush