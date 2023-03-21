<?php
$this->extend('master') ?>

<?php
$this->section('main') ?>
<x-page-head>
    <span hx-boost="true" class="flex justify-center items-center">
        <a href="<?= route_to('logs-file'); ?>" class="back mr-2 text-xs">&larr; Logs</a>
        <h2>Logs : <?= $logFilePretty; ?></h2>
    </span>

</x-page-head>

<x-admin-box>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow overflow-y-auto relative">
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white dark:bg-gray-800 table-striped relative">
            <thead>
                <tr class="text-left" hx-include="closest .card" hx-swap="morph:outerHTML" hx-target="closest .card">
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 g-white dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs"><?= lang('Logs.level'); ?></th>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 g-white dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs"><?= lang('Logs.date'); ?></th>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 g-white dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs"><?= lang('Logs.content'); ?></th>

                </tr>
            </thead>
            <tbody id="books-table-rows">
                <?php
                foreach ($logContent as $key => $log) : ?>
                    <tr <?php if (array_key_exists('extra', $log)) : ?> style="cursor:pointer" x-data="{ open: false }" <?php else : ?> class="relative dark:hover:bg-gray-600 hover:bg-slate-50 " <?php endif ?>>
                        <td class="border-dashed border-t border-gray-300 "  @click="open = ! open">
                            <span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200">
                                <span class="<?= $log['class']; ?>">
                                    &nbsp;<?= $log['level'] ?>
                                </span>
                            </span>
                        </td>
                        <td class="border-dashed border-t border-gray-300 date"  @click="open = ! open">
                            <span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200">
                                <?= app_date($log['date'], true) ?>
                            </span>
                        </td>
                        <td class="border-dashed border-t border-gray-300 text"  @click="open = ! open">
                            <span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200">
                                <?= esc($log['content']) ?>
                                <?= (array_key_exists('extra', $log)) ? '...' : ''; ?>
                            </span>
                        </td>
                    </tr>

                    <?php
                    if (array_key_exists('extra', $log)) : ?>

                        <tr class="collapse bg-light" x-show="open">
                            <td class="border-dashed border-t border-gray-300" colspan="3">
                                <span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200">
                                    <pre class="text-wrap">  <?= nl2br(trim(esc($log['extra']), " \n")) ?> </pre>
                                </span>
                            </td>
                        </tr>
                    <?php
                    endif; ?>
                <?php
                endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between border-t border-gray-200 px-4 py-3 sm:px-6">

        <?php if ($canDelete) : ?>

            <form action="<?= site_url(ADMIN_AREA . '/tools/delete-log'); ?>" class='form-horizontal' method="post">
                <?= csrf_field() ?>

                <input type="hidden" name="checked[]" value="<?= $logFile; ?>" />
                <input type="submit" name="delete" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" value="<?= lang('Logs.delete_file'); ?>" onclick="return confirm('<?= lang('Logs.delete_confirm') ?>')" />

            </form>

        <?php endif ?>

        <?= $pager->links('default', 'btw_full') ?>
    </div>




</x-admin-box>

<?php
$this->endSection() ?>