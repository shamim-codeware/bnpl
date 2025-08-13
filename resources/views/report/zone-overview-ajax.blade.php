<div class="GroupedBarChart"></div>

<script>
    var total_hirepurchase_price = <?php echo  $total_hirepurchase ?>;
    var total_paid = <?php echo $total_paid ?>;
    var total_remaining = <?php echo $total_remaining ?>;
      function groupBarChart(e, t, o = "270", hirepurchase, total_paid, total_remaining) {
             var r = {
                 series: [{
                         data: [hirepurchase]
                     },
                     {
                         data: [total_paid]
                     },
                     {
                         data: [total_remaining]
                     },
                 ],

                 colors: ["#0000ff", "#008000", "#ff0000"],
                 chart: {
                     width: t,
                     height: o,
                     type: "bar"
                 },
                 legend: {
                     show: !1
                 },
                 plotOptions: {
                     bar: {
                         borderRadius: 4,
                         horizontal: !0
                     }
                 },
                 dataLabels: {
                     enabled: !1
                 },
                 xaxis: {
                     categories: ["Total", "Collected", "Outstanding"]
                 },
             };
             $(e).length > 0 && new ApexCharts(document.querySelector(e), r).render();
         }
 groupBarChart(".GroupedBarChart", "100%", 280,total_hirepurchase_price,total_paid,total_remaining);

</script>