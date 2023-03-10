<div id="browser" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Session Browser</h3>

        <table class="table table-striped border-collapse table-auto w-full whitespace-no-wrap  bg-white dark:bg-gray-800 table-striped relative">
        <?php if (isset($sessions) && count($sessions)) :  ?>
            <tbody>
                <?php foreach ($sessions as $session) : ?>
                    <tr class="relative dark:hover:bg-gray-600 hover:bg-slate-50 ">
                        <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200"><?= $session->getTimestamp() ?></td> 
                        <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200"><?= $session->ip_address ?? '' ?></td>
                        <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200">
                            <?= $session->agent->toString() ?? '' ?>
                            <span class="text-muted fw-bold text-muted d-block fs-7"><?= $session->agent->browser->name; ?> | <?= $session->agent->device->model; ?><br /> <small><?= $session->agent->os->toString(); ?></small></span>
                        </td>
                        <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200">
                            <?php if ($session->id != session_id()) { ?>
                                <a href="#" data-kt-users-sign-out="single_user"><?= ucfirst(lang('Core.signOut')); ?></a>
                            <?php } else  if ($session->id == session_id()) { ?>
                                <span class="badge badge-light-success"><?= ucfirst(lang('Core.currentSession')); ?></span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        <?php else : ?>
            <div class="alert alert-secondary"><?= ucfirst(lang('Core.NoRecentData')); ?>.</div>
        <?php endif ?>


    </div>
</div>