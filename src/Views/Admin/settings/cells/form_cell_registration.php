<div id="registration" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.cellh3.registration'); ?></h3>


        <div class="row mb-3">

            <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [
                'label' => lang('Form.settings.AllowUsersToRegister'),
                'name' => 'allowRegistration',
                'value' => '1',
                'checked' => (old('allowRegistration', setting('Auth.allowRegistration') ?? false)),
                'description' =>  lang('Form.settings.IfUncheckedAdminWillNeed')
            ]); ?>

        </div>

        <div class="row mb-3">

            <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [
                'label' => lang('Form.settings.ForceEmailVerificationAfterRegistration'),
                'name' => 'emailActivation',
                'value' => 'Btw\Core\Authentication\Actions\EmailActivator',
                'checked' => (old('emailActivation', setting('Auth.actions')['register']) === 'Btw\Core\Authentication\Actions\EmailActivator'),
                'description' => lang('Form.settings.IfCheckedWillSendCodeViaEmailForThemToConfirm')
            ]); ?>

        </div>

        <?php if (isset($groups) && count($groups)) : ?>
            <!-- Default Group -->
            <div class="relative w-full mb-3">
                <div class="col-12 col-sm-4">

                    <label class="form-label mb-10 dark:text-gray-300"><?= lang('Form.settings.DefaultUserGroup'); ?>:</label>
                    <?php foreach ($groups as $group => $info) : ?>
                        <div class="form-check ml-4 mb-2 mt-2 ">
                            <?= view_cell('Btw\Core\Cells\RadioCell::renderList', ['label' => esc(ucfirst($info['title'])), 'name' => 'defaultGroup', 'value' => $group, 'checked' => ($group === $defaultGroup)]); ?>
                        </div>
                    <?php endforeach ?>

                </div>
                <div class="col px-5 py-4">
                    <p class="text-muted small text-sm text-gray-500 dark:text-gray-300"><?= lang('Form.settings.TheUserGroupNewlyRegisteredUsersAreMembersOf'); ?>.</p>
                </div>
            </div>
        <?php endif ?>
    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingregistration" />
    </div>

</div>