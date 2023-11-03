<div x-data="coredashboard">
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">

        <?= view_cell('Btw\Core\Cells\Charts\AdminTotalsVisitsCell', '', 300); ?>

        <?= view_cell('Btw\Core\Cells\Charts\AdminVisitorsBrowserCell', '', 300); ?>

    </div>
</div>