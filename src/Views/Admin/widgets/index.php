<div class='flex mb-5' hx-ext="echarts" _="on htmx:afterOnLoad take .text-indigo-600 for event.target">
<?= view_cell('Btw\Core\Cells\Charts\AdminChartFilter', [
    'period' => 'week',
    'route' => route_to('charts-hx-update'),
    'selected' => true,
    'type' => 'page_views',
    'label' => 'Last Week'
  ]) ?>

<?= view_cell('Btw\Core\Cells\Charts\AdminChartFilter', [
    'period' => 'month',
    'route' => route_to('charts-hx-update'),
    'selected' => false,
    'type' => 'page_views',
    'label' => 'Last Month'
  ]) ?>
  
</div>

<!-- <div hx-get="<?= route_to('charts-hx'); ?>" hx-swap="innerHTML" hx-target="#charts"></div> -->
<div id="charts" class="rounded-lg bg-white p-8 h-[20rem]"></div>


<script type="module">
      // Initialize the echarts instance based on the prepared dom
      var myChart = echarts.init(document.getElementById('charts'));

      // Specify the configuration items and data for the chart
      var option = {
        title: {
          text: 'ECharts Getting Started Example'
        },
        tooltip: {},
        legend: {
          data: ['sales']
        },
        xAxis: {
          data: <?= json_encode($data['xAxis']['data']); ?>
        },
        yAxis: {},
        series: [
          {
            name: 'sales',
            type: 'bar',
            data: <?= json_encode($data['series']['data']); ?>
          }
        ]
      };

      // Display the chart using the configuration items and data just specified.
      myChart.setOption(option);
    </script>