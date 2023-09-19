<div id="formregisterback">
    <!-- Email -->
    <div class="mb-2">
        <!-- <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required /> -->
        <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
            'type' => 'email',
            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
            'label' => false,
            'placeholder' => lang('Auth.email'),
            'name' => 'email',
            'value' => old('email')
        ]); ?>
    </div>

    <!-- Username -->
    <div class="mb-4">
        <!-- <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required /> -->
        <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
            'type' => 'text',
            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
            'label' => false,
            'placeholder' => lang('Auth.username'),
            'name' => 'username',
            'value' => old('username')
        ]); ?>
    </div>

    <!-- Password -->
    <div x-data="{ show: true }">
        <div class="mb-2">
            <!-- <input type="password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required /> -->
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

        <!-- Password (Again) -->
        <div class="mb-5">
            <!-- <input type="password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required /> -->
            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'password',
                'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                'label' => false,
                'placeholder' => lang('Auth.passwordConfirm'),
                'name' => 'password_confirm',
                'value' => old('password_confirm'),
                'xType' => "show ? 'password' : 'text'",
                'xModel' => "password_confirm"
            ]); ?>
        </div>
    </div>

    <div class="d-grid col-12 col-md-8 mx-auto m-3">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', [
            'type' => 'type',
            'text' => lang('Auth.register'),
            'loading' => "loadingchangepassword",
            'back' => null,
            'click' => null,
            'class' => "w-full"
        ]) ?>
        <!-- <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><?= lang('Auth.register') ?></button> -->
    </div>

</div>