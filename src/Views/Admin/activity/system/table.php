<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow overflow-y-auto relative">
    <table class="hidden w-full" data-kt-datatable-row="selected">
        <tr class=" dark:bg-gray-700  bg-indigo-50 dark:bg-gray-800  dark:hover:bg-gray-600 hover:bg-slate-50 dark:text-white">
            <td class="px-6 py-4 bg-indigo-50 dark:bg-gray-800 whitespace-nowrap text-sm font-medium dark:text-white" colspan="10">
                <div class="selected">
                    <span>
                        <?= lang('Btw.You are currently selecting');?> <strong><span class="me-2" data-kt-datatable-select="selected_count"></span></strong> <?= lang('Btw.rows');?>
                    </span>

                    <!-- <button type="button" class="ml-1 text-blue-600 underline0 text-sm leading-5 font-medium focus:outline-none focus:text-gray-800 focus:underline transition duration-150 ease-in-out dark:text-white dark:hover:text-gray-400">
                    <?= ucfirst(lang('Btw.Deselect All'));?> </button> -->
                </div>
            </td>
        </tr>
    </table>
    <table class="border-collapse table-auto w-full whitespace-no-wrap  bg-white dark:bg-gray-800 table-striped relative" id="kt_table_system" hx-boost="true">
        <thead>
            <tr class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs">
                <?php $i = 0;
                foreach ($columns as $column) : ?>
                    <?php if ($column['name'] == 'selection') : ?>
                        <th class="">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input allCheck w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_system .form-check-input" value="1" />
                            </div>
                        </th>
                    <?php else : ?>
                        <?php if (isset($column['orderable'])) : ?>
                            <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs"><?= $column['header']; ?></th>
                         <?php else : ?>
                            <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs"> <?= $column['header']; ?></th>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php $i++;
                endforeach; ?>
            </tr>

        </thead>
    </table>
</div>