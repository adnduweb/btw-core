<div id="tokencreate" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Général</h3>

        <!-- Site Name -->
        <div class="row">
            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'text',
                'label' => lang('Btw.NameTokens'),
                'name' => 'siteName',
                'value' => old('siteName', setting('Site.NameToken')),
                'description' => "Appears in admin, and is available throughout the site."
            ]); ?>
        </div>


    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadinggeneral" />
    </div>

</div>