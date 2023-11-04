<?php if (empty($logs)) : ?>
    <div class="card-body">
        <div class="empty">
            <p class="empty-title">No logs</p>
            <p class="empty-subtitle text-muted">
                No logs found :(
            </p>
        </div>
    </div>
<?php else : ?>
    <div x-data="listen" class="overflow-x-auto0 rounded-lg shadow overflow-y-auto relative">
        <table class="border-collapse table-auto w-full whitespace-no-wrap table-striped relative" hx-boost="false">
            <thead>
                <tr class="text-left">
                    <?php if (auth()->user()->can('logs.manage')) : ?>
                        <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 g-white dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs column-check text-center" style="width: 2rem">
                            <input class="form-check-input allCheck w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 select-all" type="checkbox" />
                        </th>
                    <?php endif ?>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 g-white dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs">date</th>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 g-white dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs">file</th>
                </tr>
            </thead>
            <tbody id="books-table-rows">
                <?php foreach ($logs as $key => $log) : ?>
                    <?= $this->setData(['log' => $log, 'key' => $key])->include('Btw\Core\Views\Admin\activity\files\table_row'); ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>