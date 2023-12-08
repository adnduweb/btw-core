<div id="twofactor" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5  space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.sidebar.TwoFactoAuthentification'); ?></h3>


        <div class="row mb-3">

            <?= view_cell('Btw\Core\Cells\Forms\SwitchCell::renderList', [
                'label' => lang('Form.settings.Force2FACheckAfterLogin'),
                'name' => 'email2FA',
                'value' => 'Btw\Core\Authentication\Actions\Email2FA',
                'checked' => (old('email2FA', setting()->get('Auth.actions', 'user:' . user_id())['login']) === 'Btw\Core\Authentication\Actions\Email2FA'),
                'description' => lang('Form.settings.Force2FACheckAfterLoginDesc')
            ]); ?>

        </div>

        <div x-data="{ Google2FA: <?= old('Google2FA', setting()->get('Auth.activateG2Factor', 'user:' . user_id())) ? 'true' : 'false' ?>}">
            <div class="row mb-3">

                <?= view_cell('Btw\Core\Cells\Forms\SwitchCell::renderList', [
                    'label' => lang('Form.settings.ForceGoogle2FACheckAfterLogin'),
                    'name' => 'Google2FA',
                    'value' => 'Btw\Core\Authentication\Actions\Google2FA',
                    'hxGet' => route_to('profile-get-authentification-2google'),
                    'hxTarget' => '#google2FA',
                    'disabled' =>   service('settings')->get('Auth.activateG2Factor', 'user:' . user_id()) ? true : false,
                    'checked' => (old('Google2FA', setting()->get('Auth.activateG2Factor', 'user:' . user_id()))),
                    'description' => lang('Form.settings.ForceGoogle2FACheckAfterLoginDesc')
                ]); ?>

            </div>
            <div id="google2FA" x-show="Google2FA == <?= old('Google2FA', setting()->get('Auth.activateG2Factor', 'user:' . user_id())) ? 'true' : 'false' ?>" class="w-full mt-6 mb-6 md:mb-0">
                <?= $this->include('Btw\Core\Views\Admin\users\profile\cells\form_cell_two_factor_2_google'); ?>
            </div>
        </div>


    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loadingtwofactor"]) ?>
    </div>
</div>