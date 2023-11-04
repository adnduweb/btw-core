<div id="general" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5  space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.sidebar.historyLogin'); ?></h3>

        <table class="table table-striped border-collapse table-auto w-full whitespace-no-wrap  table-striped relative">
            <thead>
                <tr>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600  bg-white dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs">Date</th>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600  bg-white dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs">IP Address</th>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600  bg-white dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs">User Agent</th>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600  bg-white dark:bg-gray-700 dark:text-gray-300 font-bold tracking-wider uppercase text-xs">Success</th>
                </tr>
            </thead>
            <?php if (isset($logins) && count($logins)) : ?>
                <tbody>
                    <?php foreach ($logins as $login) : ?>
                        <tr class="relative dark:hover:bg-gray-800 hover:bg-slate-50 ">
                            <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200"><?= app_date($login->date, true, true) ?></td>
                            <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200"><?= $login->ip_address ?? '' ?></td>
                            <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200"><?= $login->user_agent ?? '' ?></td>
                            <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200">
                                <?php if ($login->success) : ?>
                                    <span class="text-xs font-semibold inline-block py-1 px-2 rounded-full text-green-600 bg-green-200 uppercase last:mr-0 mr-1"><?= lang('Btw.general.success'); ?></span>
                                <?php else : ?>
                                    <span class="text-xs font-semibold inline-block py-1 px-2 rounded-full text-pink-600 bg-pink-200 uppercase last:mr-0 mr-1"><?= lang('Btw.general.failed'); ?></span>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            <?php else : ?>
                <div class="alert alert-secondary">No recent login attempts.</div>
            <?php endif ?>
        </table>

    </div>
</div>