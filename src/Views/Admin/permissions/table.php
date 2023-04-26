<div class="card">
    <?php if (empty($permissions)) : ?>
        <div class="card-body">
            <div class="empty">
                <p class="empty-title">No permissions</p>
                <p class="empty-subtitle text-muted">
                    No permissions found :(
                </p>
            </div>
        </div>
    <?php else : ?>
        <div x-data="listen" class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow overflow-y-auto relative" hx-boost="false">
            <table class="border-collapse table-auto w-full whitespace-no-wrap dark:bg-gray-800 table-striped relative">
                <thead>
                    <tr class="text-left"  hx-include="closest .card" hx-swap="morph:outerHTML" hx-target="closest .card">
                        <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs"><?= anchor($table->sortByURL('nom'), 'Nom', ['hx-get' => site_url($table->sortByURL('nom'))]); ?> <?= $table->getSortIndicator('nom'); ?></th>
                        <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs"><?= anchor($table->sortByURL('description'), 'Description', ['hx-get' => site_url($table->sortByURL('description'))]); ?> <?= $table->getSortIndicator('description'); ?></th>
                        <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs"> -- </th>
                    </tr>
                </thead>
                <tbody id="permissions-table-rows">
                    <?php foreach ($permissions as $k => $v) : ?>
                        <?= $this->setData(['permission' => [$k, $v]])->include('Btw\Core\Views\Admin\permissions\table_row'); ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>