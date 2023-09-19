<div id="formloginback">
    <!-- Email -->
    <div class="mb-2">
        <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
            'type' => 'email',
            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
            'label' => false,
            'placeholder' => lang('Auth.email'),
            'name' => 'email',
            'value' => old('email')
        ]); ?>
    </div>

    <!-- Password -->
    <div class="mb-2" x-data="{ show: true }">
        <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
            'type' => 'password',
            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
            'label' => false,
            'placeholder' => lang('Auth.password'),
            'name' => 'password',
            'value' => old('password'),
            'xType' => "show ? 'password' : 'text'"
        ]); ?>
    </div>



    <div class="flex items-center justify-between">

        <!-- Remember me -->
        <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>

            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input type="checkbox" name="remember" class="form-check-input w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" <?php if (old('remember')) : ?> checked<?php endif ?>>
                </div>
                <div class="ml-3 text-sm">
                    <label for="remember" class="text-gray-500 dark:text-gray-300"><?= lang('Auth.rememberMe') ?></label>
                </div>
            </div>


        <?php endif; ?>

        <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
            <a href="<?= url_to('magic-link') ?>" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                <?= lang('Auth.forgotPassword') ?>
            </a>
        <?php endif ?>
    </div>


    <div class="d-grid col-12 col-md-8 mx-auto m-3">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', [
            'type' => 'type',
            'text' => lang('Auth.login'),
            'loading' => "loadingchangepassword",
            'back' => null,
            'click' => null,
            'class' => "w-full"
        ]) ?>
    </div>

</div>