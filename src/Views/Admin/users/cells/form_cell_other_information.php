<div id="general" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Other information</h3>

        <?php ''; //print_r(auth()->user()->getGroups());  exit;
        //print_r($userCurrent->getGroups()); exit;
        ?>

        <table class="min-w-full bg-white dark:bg-gray-800 table-auto">
            <tbody class="text-gray-700 dark:text-gray-200 ">
                <tr>
                    <td class="text-left py-3 px-4"><?= lang('Btw.Account Type'); ?></td>
                    <td class="text-left py-3 px-4" hx-get="/admin/user/update-group" hx-trigger="load delay:1s, updateGroupUserCurrent from:body"> <?= $this->setVar('userCurrent', $userCurrent)->include('Btw\Core\Views\Admin\users\cells\line_group'); ?></td>
                    <td>
                        <button @click="modelOpen =!modelOpen" class="">
                        <?= lang('Btw.change'); ?>
                        </button>
                    </td>
                </tr>
                <tr class="bg-gray-100 dark:bg-gray-700 ">
                    <td class="text-left py-3 px-4"><?= lang('Btw.Active'); ?></td>
                    <td class="text-left py-3 px-4"> <?= (auth()->user()->active == 1) ? '<span class="text-xs font-semibold inline-block py-1 px-2 rounded-full text-green-600 bg-green-200 uppercase last:mr-0 mr-1">' . lang('Btw.yes') . '</span>' : '<span class="text-xs font-semibold inline-block py-1 px-2 rounded-full text-pink-600 bg-pink-200 uppercase last:mr-0 mr-1">' . lang('Btw.no') . '</span>'  ?> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td class="text-left py-3 px-4"><?= lang('Btw.Timezone'); ?></td>
                    <td class="text-left py-3 px-4"> <?= setting('User.Timezone', 'user:' . user_id()) ?? "N/A"; ?> </td>
                    <td> </td>
                </tr>
                <tr class="bg-gray-100 dark:bg-gray-700 ">
                    <td class="text-left py-3 px-4"><?= lang('Btw.Email Verified'); ?></td>
                    <td class="text-left py-3 px-4"> <?= (auth()->user()->email_verified_at) ?? '<span class="text-xs font-semibold inline-block py-1 px-2 rounded-full text-pink-600 bg-pink-200 uppercase last:mr-0 mr-1">' . lang('Btw.no') . '</span>'; ?> </td>
                    <td>
                        <?php if (auth()->user()->email_verified_at == null) : ?>
                            <button @click="modelOpen =!modelOpen" class="">
                                <?= lang('Btw.verifie'); ?>
                            </button>
                        <?php endif ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-left py-3 px-4"><?= lang('Btw.Account Created'); ?></td>
                    <td class="text-left py-3 px-4"> <?= app_date((auth()->user()->created_at), true) ?? '<span class="text-xs font-semibold inline-block py-1 px-2 rounded-full text-pink-600 bg-pink-200 uppercase last:mr-0 mr-1">' . lang('Btw.no') . '</span>'; ?> </td>
                    <td> </td>
                </tr>
                <tr class="bg-gray-100 dark:bg-gray-700 ">
                    <td class="text-left py-3 px-4"><?= lang('Btw.Last Updated'); ?></td>
                    <td class="text-left py-3 px-4"> <?= app_date((auth()->user()->updated_at), true) ?? '<span class="text-xs font-semibold inline-block py-1 px-2 rounded-full text-pink-600 bg-pink-200 uppercase last:mr-0 mr-1">' . lang('Btw.no') . '</span>'; ?> </td>
                    <td> </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>



<?php $this->section('modals') ?>

<div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
        <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

        <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl 2xl:max-w-2xl">
            <div class="flex items-center justify-between space-x-4">
                <h1 class="text-xl font-medium text-gray-800 ">Invite team memebr</h1>

                <button @click="modelOpen = false" class="text-gray-600 dark:text-gray-300 focus:outline-none hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-300 ">
                Add your teammate to your team and start work to get things done
            </p>


            <?= form_open(route_to('user-current-settings'), [
                'id' => 'kt_users_form_modalgroups', 'hx-post' => route_to('user-current-settings'), 'hx-target' => '#modalgroups', 'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadingmodalgroups",
                'data-loading-class-remove' => "hidden"
            ]); ?>
            <?= csrf_field() ?>
            <input type="hidden" name="section" value="groups" />

            <?= $this->include('Btw\Core\Views\Admin\users\cells\cell_groups'); ?>


            <?= form_close(); ?>
        </div>
    </div>
</div>

<?php $this->endSection() ?>