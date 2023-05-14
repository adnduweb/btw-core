<div id="login" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div x-data="{remember: <?= old('allowRemember', setting('Auth.sessionConfig')['allowRemembering']) ? 1 : 0 ?>}" class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.cellh3.login'); ?></h3>

        <div class="row mb-3">
            <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [
                'label' => lang('Form.settings.AllowUsersToBeRemembered'),
                'name' => 'allowRemember',
                'value' => '1',
                'checked' => (old('allowRemember', setting('Auth.sessionConfig')['allowRemembering'])),
                'description' => lang('Form.settings.IfUncheckedOnlySuperadmin'),
                'xOnClick' => "remember = ! remember"
            ]); ?>

        </div>

        <div class="row mb-3" x-show="remember">
            <div class="form-group col-12 col-sm-4">

                <?= view_cell('Btw\Core\Cells\SelectCell::renderList', [
                    'label' => lang('Form.settings.RememberUsersForHowLong'),
                    'name' => 'rememberLength',
                    'options' => $rememberOptions,
                    'selected' =>  old('rememberLength', setting('Auth.sessionConfig')['rememberLength']),
                    'description' => lang('Form.settings.IfCheckedWillSendCodeViaEmail'),
                ]); ?>

            </div>
        </div>

        <div class="row mb-3">
nkkjljlkj
            <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [
                'label' => lang('Form.settings.Force2FACheckAfterLogin'),
                'name' => 'email2FA',
                'value' => 'Btw\Core\Authentication\Actions\Email2FA',
                'checked' => (old('email2FA', setting('Auth.actions')['login']) === 'Btw\Core\Authentication\Actions\Email2FA'),
                'description' => lang('Form.settings.2FAIfCheckedWillSendCodeViaEmail'),
            ]); ?>

        </div>

    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadinglogin" />
    </div>
</div>