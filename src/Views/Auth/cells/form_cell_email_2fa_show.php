<div id="formauthactionhandle">
    <!-- Email -->
    <div class="mb-2">
        <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" <?php /** @var \CodeIgniter\Shield\Entities\User $user */ ?> value="<?= old('email') ?>" required />
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
</diV>