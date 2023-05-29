<div class='flex mb-5' hx-ext="echarts" _="on htmx:afterOnLoad take .text-indigo-600 for event.target">
    <?= $this->setData([
        'period' => 'week',
        'selected' => true,
        'type' => 'page_views',
        'label' => 'Last Week'
    ])->include('Themes\Admin\Components\chart_filter'); ?>

    <?= $this->setData([
        'period' => 'month',
        'selected' => false,
        'type' => 'page_views',
        'label' => 'Last Month'
    ])->include('Themes\Admin\Components\chart_filter'); ?>

</div>

<!-- <div hx-get="<?= route_to('charts-hx'); ?>" hx-swap="innerHTML" hx-target="#charts"></div> -->
<div id="charts" class="rounded-lg bg-white p-8 h-[20rem]"></div>