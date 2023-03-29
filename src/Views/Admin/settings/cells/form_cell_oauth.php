<div id="oauth" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">


        <div class="row mb-3">
            <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [
                'label' => lang('ShieldOAuthLang.allow_login'),
                'name' => 'allow_login',
                'value' => '1',
                'checked' => (old('allow_login', setting('ShieldOAuthConfig.allow_login') ?? false))
            ]); ?>
        </div>

        <div class="row mb-3">
            <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [
                'label' => lang('ShieldOAuthLang.allow_register'),
                'name' => 'allow_register',
                'value' => '1',
                'checked' => (old('allow_register', setting('ShieldOAuthConfig.allow_register') ?? false))
            ]); ?>
        </div>

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200 mb-5"><?= lang('ShieldOAuthLang.Type_connect'); ?></h3>


        <div x-data="{allow_login_google: <?= old('allow_login_google', setting('ShieldOAuthConfig.allow_login_google')) ? true : 'false' ?>}">

            <div class="row mb-3">
                <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [
                    'label' => lang('ShieldOAuthLang.allow_login_google'),
                    'name' => 'allow_login_google',
                    'value' => '1',
                    'checked' => (old('allow_login_google', setting('ShieldOAuthConfig.allow_login_google') ?? false)),
                    'xNotData' => "true",
                    'xOn' => "allow_login_google",
                    'xChange' => "allow_login_google = ! allow_login_google"
                ]); ?>
 
            </div>

            <!-- Site Name -->
            <div class="row" x-show="allow_login_google != false">


                <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('ShieldOAuthLang.client_id'),
                    'name' => 'google_client_id',
                    'value' => old('google_client_id', setting('ShieldOAuthConfig.google_client_id'))
                ]); ?>


                <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('ShieldOAuthLang.client_secret'),
                    'name' => 'google_client_secret',
                    'value' => old('google_client_secret', setting('ShieldOAuthConfig.google_client_secret'))
                ]); ?>

            </div>
        </div>

        <div x-data="{allow_login_github: <?= old('allow_login_github', setting('ShieldOAuthConfig.allow_login_github')) ? true : 'false' ?>}">
            <div class="row mb-3">

                <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [
                    'label' => lang('ShieldOAuthLang.allow_login_github'),
                    'name' => 'allow_login_github',
                    'value' => '1',
                    'checked' => (old('allow_login_github', setting('ShieldOAuthConfig.allow_login_github') ?? false)),
                    'xNotData' => "true",
                    'xOn' => "allow_login_github",
                    'xChange' => "allow_login_github = ! allow_login_github"
                ]); ?>

            </div>

            <!-- Site Name -->
            <div class="row" x-show="allow_login_github != false">

                <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('ShieldOAuthLang.client_id'),
                    'name' => 'github_client_id',
                    'value' => old('github_client_id', setting('ShieldOAuthConfig.github_client_id'))
                ]); ?>

                <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('ShieldOAuthLang.client_secret'),
                    'name' => 'github_client_secret',
                    'value' => old('github_client_secret', setting('ShieldOAuthConfig.github_client_secret'))
                ]); ?>

            </div>
        </div>

    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadinggeneral" />
    </div>

</div>