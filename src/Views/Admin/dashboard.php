<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>
<?= lang('Auth.login') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head>Dashboard </x-page-head>


<div class='flex' hx-ext="echarts" 
    _="on htmx:afterOnLoad take .text-indigo-600 for event.target"
 >
 <?= $this->setData([
    'period' => 'week', 
    'selected' => true , 
    'type' => 'page_views',
    'label' => 'Last Week'
    ])->include('Themes\Admin\Components\chart_filter'); ?>


   {% include 'components/chart_filter.html' with period='week' c=charts.0 label='Last Week' selected=True %}
   {% include 'components/chart_filter.html' with period='month' c=charts.0 label='Last Month' %} 
</div>




// In a View. Initialize the protected properties.
<?= view_cell('ComponentChartCell', ['type' => 'note', 'message' => 'test']); ?>

    <div id="charts" class="rounded-lg bg-white p-8 h-[20rem]"></div>



<x-admin-box>

</x-admin-box>

<?= $this->endSection() ?>


<?php $this->section('scripts') ?>
<script type="module">
    // Create the echarts instance
    var myChart = echarts.init(document.getElementById('charts'));
    window.addEventListener('resize', function () {
        myChart.resize();
    });

    // Draw the chart
    myChart.setOption({
        title: {
            text: 'ECharts Getting Started Example'
        },
        tooltip: {},
        xAxis: {
            data: ['shirt', 'cardigan', 'chiffon', 'pants', 'heels', 'socks']
        },
        yAxis: {},
        series: [
            {
                name: 'sales',
                type: 'bar',
                data: [5, 20, 36, 10, 10, 20]
            }
        ]
    });
</script>
<?= $this->endSection() ?>