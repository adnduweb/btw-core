<div id="formauthactionverify">
    <!-- Code -->
    <div class="mb-2">
        <input type="number"
            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            name="token" placeholder="000000" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code"
            required />
    </div>

    <div class="d-grid col-12 col-md-8 mx-auto m-3">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', [
            'type' => 'type',
            'text' => lang('Auth.confirm'),
            'loading' => "formauthactionverify",
            'back' => null,
            'click' => null,
            'class' => "w-full"
        ]) ?>
    </div>
</div>