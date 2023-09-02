<tr class="relative dark:hover:bg-gray-600 hover:bg-slate-50 ">
    <?php if (auth()->user()->can('logs.manage')) : ?>
        <td class="border-dashed border-t border-gray-300 column-check text-center">
            <input type="checkbox" value="<?= esc($log); ?>" name="checked[]" class="form-check-input allCheck w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
        </td>
    <?php endif ?>
    <td class='border-dashed border-t border-gray-300 date'>
        <a href="<?= site_url(route_to('log-file-view', $log)); ?>">
            <span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200">
                <?= date('F j, Y', strtotime(str_replace('.log', '', str_replace('log-', '', $log)))); ?>
            </span>
        </a>
    </td>
    <td class='border-dashed border-t border-gray-300'>
        <a href="<?= site_url(route_to('log-file-view', $log)); ?>">
            <span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200">
                <?= esc($log); ?>
            </span>
        </a>
    </td>
</tr>