<div id="twofactor" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Two Facto Authentificationr</h3>


        <div class="row mb-3">
            <x-inputs.checkbox label="<?= lang('Btw.Force 2FA check after login?'); ?>" name="email2FA" value="Btw\Core\Authentication\Actions\Email2FA" checked="<?= (old('email2FA', setting()->get('Auth.actions', 'user:' . user_id())['login']) === 'Btw\Core\Authentication\Actions\Email2FA') ?>" description="If checked, will send a code via email for them to confirm." />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('email2FA'); ?>
                </div>
            <?php endif ?>
        </div>

    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 dark:bg-gray-700 ">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingtwofactor" />
    </div>

</div>