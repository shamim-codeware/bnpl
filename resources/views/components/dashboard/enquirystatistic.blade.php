<div class="d-flex flex-column align-items-center justify-content-center gap-3">
    <!-- Row: Left legend + Pie -->
    <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap">
        <!-- Left Legend with % -->
        <div id="custom-pie-legend-left" class="d-flex flex-column gap-2 small text-nowrap">
        </div>

        <!-- Pie in the middle -->
        <div class="apexpie">
            <div class="apexPieToday"></div>
        </div>
    </div>

    <!-- Bottom Legend (original) -->
    <div id="custom-pie-legend" class="d-flex flex-wrap gap-2 justify-content-center mt-2 small text-nowrap">
    </div>
</div>


<script>
    var group_name = {!! $group_name !!};
    console.log(group_name);
    var selList = {!! $selList !!};
    console.log(selList);

    function pieChart(idName, series, width = 150, height = 150) {
        if (!Array.isArray(series) || series.length === 0 || series.reduce((a, b) => a + b, 0) === 0) return;

        var colors = [
            '#F4A900', // IPS
            '#0E7E12', // TV
            '#F8BC8F', // WM
            '#FF0000', // MWO
            '#4E79A7', // AC
            '#640D5F', // WP
            '#E15759' // REF
        ];
        var labels = group_name;

        var optionsPie = {
            series: series,
            labels: labels,
            colors: colors,
            chart: {
                type: 'pie',
                group: 'social',
                width: width,
                height: height,
            },
            noData: {
                text: 'No data available',
                align: 'center',
                verticalAlign: 'middle',
                style: {
                    color: '#ccc',
                    fontSize: '16px'
                }
            },
            legend: {
                show: false
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        minAngleToShowLabel: undefined
                    }
                }
            },
            responsive: [{
                breakpoint: 1399,
                options: {
                    chart: {
                        width: "100%"
                    }
                }
            }]
        };

        if ($(idName).length > 0) {
            new ApexCharts(document.querySelector(idName), optionsPie).render();

            const total = series.reduce((a, b) => a + b, 0);
            let legendHtmlLeft = '';
            let legendHtmlBottom = '';

            for (let i = 0; i < series.length; i++) {
                const value = series[i];
                const percent = total > 0 ? ((value / total) * 100).toFixed(1) : '0.0';

                // ✅ Left legend: show all values including 0
                legendHtmlLeft += `
            <div class="d-flex align-items-center mb-1">
                <span class="d-inline-block me-2"
                      style="width:12px;height:12px;background-color:${colors[i]}"></span>
                <span class="me-2 fw-bold">${percent}%</span>
                <span>${labels[i]}</span>
            </div>`;

                // ✅ Bottom legend: only non-zero values
                // if (value > 0) {
                legendHtmlBottom += `
                <div class="d-flex align-items-center me-3 mb-2">
                    <span class="d-inline-block me-1"
                          style="width:12px;height:12px;background-color:${colors[i]}"></span>
                    ${labels[i]} (${value})
                </div>`;
                // }
            }

            $('#custom-pie-legend-left').html(legendHtmlLeft);
            $('#custom-pie-legend').html(legendHtmlBottom);
        }

    }

    pieChart('.apexPieToday', selList, '100%', 270);
</script>
