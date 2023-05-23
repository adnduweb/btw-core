<div id="twofactor" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.sidebar.TwoFactoAuthentification'); ?></h3>


        <div class="row mb-3">
            
            <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [
                 'label' => lang('Form.settings.Force2FACheckAfterLogin'),
                'name' => 'email2FA',
                'value' => 'Btw\Core\Authentication\Actions\Email2FA',
                'checked' => (old('email2FA', setting()->get('Auth.actions', 'user:' . user_id())['login']) === 'Btw\Core\Authentication\Actions\Email2FA'),
                'description' => lang('Form.settings.Force2FACheckAfterLoginDesc')
            ]); ?>

        </div>

    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingtwofactor" />
    </div>

</div>