<div id="oauth" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">


        <div class="row mb-3">
            <x-inputs.switch label="<?= lang('ShieldOAuthLang.allow_login'); ?>" name="allow_login" value="1" checked="<?= (old('allow_login', setting('ShieldOAuthConfig.allow_login') ?? false)) ?>" description="false" />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('allow_login'); ?>
                </div>
            <?php endif ?>
        </div>

        <div class="row mb-3">
            <x-inputs.switch label="<?= lang('ShieldOAuthLang.allow_register'); ?>" name="allow_register" value="1" checked="<?= (old('allow_register', setting('ShieldOAuthConfig.allow_register') ?? false)) ?>" description="false" />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('allow_register'); ?>
                </div>
            <?php endif ?>
        </div>

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200 mb-5"><?= lang('ShieldOAuthLang.Type_connect'); ?></h3>


        <div x-data="{google_allow_login: <?= old('google_allow_login', setting('ShieldOAuthConfig.google_allow_login')) ? true : 'false' ?>}">

            <div class="row mb-3">
                <x-inputs.switch label="<?= lang('ShieldOAuthLang.allow_login_google'); ?>" name="google_allow_login" value="1" checked="<?= (old('google_allow_login', setting('ShieldOAuthConfig.google_allow_login') ?? false)) ?>" description="false" xNotData="true" xOn="google_allow_login" xChange="google_allow_login = ! google_allow_login" />
                <?php if (isset($validation)) :  ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('google_allow_login'); ?>
                    </div>
                <?php endif ?>
            </div>

            <!-- Site Name -->
            <div class="row" x-show="google_allow_login != false">
                <x-label for="google_client_id" label="<?= lang('ShieldOAuthLang.client_id'); ?>" />
                <x-inputs.text name="google_client_id" value="<?= old('google_client_id', setting('ShieldOAuthConfig.google_client_id')) ?>" description="false" />
                <?php if (isset($validation)) :  ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('google_client_id'); ?>
                    </div>
                <?php endif ?>
                <x-label for="google_client_secret" label="<?= lang('ShieldOAuthLang.client_secret'); ?>" />
                <x-inputs.text name="google_client_secret" value="<?= old('google_client_secret', setting('ShieldOAuthConfig.google_client_secret')) ?>" description="false" />
                <?php if (isset($validation)) :  ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('google_client_secret'); ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div x-data="{allow_login_github: <?= old('allow_login_github', setting('ShieldOAuthConfig.allow_login_github')) ? true : 'false' ?>}">
            <div class="row mb-3">
                <x-inputs.switch label="<?= lang('ShieldOAuthLang.allow_login_github'); ?>" name="github_allow_login" value="1" checked="<?= (old('github_allow_login', setting('ShieldOAuthConfig.github_allow_login') ?? false)) ?>" description="false"  xNotData="true" xOn="allow_login_github" xChange="allow_login_github = ! allow_login_github" />
                <?php if (isset($validation)) :  ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('github_allow_login'); ?>
                    </div>
                <?php endif ?>
            </div>

            <!-- Site Name -->
            <div class="row" x-show="allow_login_github != false">
                <x-label for="github_client_id" label="<?= lang('ShieldOAuthLang.client_id'); ?>" />
                <x-inputs.text name="github_client_id" value="<?= old('github_client_id', setting('ShieldOAuthConfig.github_client_id')) ?>" description="false" />
                <?php if (isset($validation)) :  ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('github_client_id'); ?>
                    </div>
                <?php endif ?>
                <x-label for="github_client_secret" label="<?= lang('ShieldOAuthLang.client_secret'); ?>" />
                <x-inputs.text name="github_client_secret" value="<?= old('github_client_secret', setting('ShieldOAuthConfig.github_client_secret')) ?>" description="false" />
                <?php if (isset($validation)) :  ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('github_client_secret'); ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 dark:bg-gray-700 ">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" loading="loadinggeneral" />
    </div>

</div>