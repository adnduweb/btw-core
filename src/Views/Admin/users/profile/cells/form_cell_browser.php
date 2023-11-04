<div id="browser" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.sidebar.historyBrowser'); ?></h3>

        <table class="table table-striped border-collapse table-auto w-full whitespace-no-wrap table-striped relative">
        <?php if (isset($sessions) && count($sessions)) :  ?>
            <tbody>
                <?php foreach ($sessions as $session) : ?>
                    <tr class="relative dark:hover:bg-gray-800 hover:bg-slate-50 ">
                        <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200"><?= $session->getTimestamp() ?></td> 
                        <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200"><?= $session->ip_address ?? '' ?></td>
                        <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200">
                            <?= $session->agent->toString() ?? '' ?>
                            <span class="text-muted fw-bold text-muted d-block fs-7"><?= $session->agent->browser->name; ?> | <?= $session->agent->device->model; ?><br /> <small><?= $session->agent->os->toString(); ?></small></span>
                        </td>
                        <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200">
                            <?php if ($session->id != session_id()) { ?>
                                <a href="#" data-kt-users-sign-out="single_user"><?= ucfirst(lang('Btw.general.signOut')); ?></a>
                            <?php } elseif ($session->id == session_id()) { ?>
                                <span class="badge badge-light-success"><?= ucfirst(lang('Btw.general.currentSession')); ?></span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        <?php else : ?>
            <div class="alert alert-secondary"><?= ucfirst(lang('Core.NoRecentData')); ?>.</div>
        <?php endif ?>
        </table>

    </div>
</div>