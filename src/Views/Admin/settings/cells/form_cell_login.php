<div id="login" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div x-data="{remember: <?= old('allowRemember', setting('Auth.sessionConfig')['allowRemembering']) ? 1 : 0 ?>}" class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Login</h3>

        <div class="row mb-3">
            <x-inputs.switch label="<?= lang('Btw.Allow users to be remembered'); ?>" name="allowRemember" value="1" checked="<?= (old('allowRemember', setting('Auth.sessionConfig')['allowRemembering'])) ?>" description="This makes it so users do not have to login every visit." xOnClick="remember = ! remember" />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('allowRemember'); ?>
                </div>
            <?php endif ?>
        </div>

        <div class="row mb-3" x-show="remember">
            <div class="form-group col-12 col-sm-4">
                <x-inputs.select label="<?= lang('Btw.Remember Users for how long?'); ?>" name="rememberLength" selected="<?= (old('rememberLength', setting('Auth.sessionConfig')['rememberLength'])) ?>">
                    <?= view_cell('Btw\Core\Cells\Select::renderList', ['options' => $rememberOptions, 'selected' => (old('rememberLength', setting('Auth.sessionConfig')['rememberLength']))]); ?>
                </x-inputs.select>
            </div>
        </div>

        <div class="row mb-3">
            <x-inputs.switch label="<?= lang('Btw.Force 2FA check after login?'); ?>" name="email2FA" value="Btw\Core\Authentication\Actions\Email2FA" checked="<?= (old('email2FA', setting('Auth.actions')['login']) === 'Btw\Core\Authentication\Actions\Email2FA') ?>" description="If checked, will send a code via email for them to confirm general application." />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('email2FA'); ?>
                </div>
            <?php endif ?>
        </div>

    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 dark:bg-gray-700 ">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" loading="loadinglogin" />
    </div>
</div>