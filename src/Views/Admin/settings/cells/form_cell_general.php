<div id="general" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.cellh3.general'); ?></h3>

        <!-- Site Name -->
        <div class="row">
            <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                'type' => 'text',
                'label' => lang('Form.general.siteName'),
                'name' => 'siteName',
                'value' => old('siteName', setting('Site.siteName')),
                'description' => lang('Form.general.siteNameDesc'),
            ]); ?>
        </div>

        <!-- Site Online? -->
        <div class="row">

            <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [
                'type' => 'text',
                'label' => lang('Btw.siteOnline'),
                'name' => 'siteOnline',
                'value' => '1',
                'checked' => (old('siteOnline', setting('Site.siteOnline') ?? false)),
                'description' => lang('Form.general.siteOnlineDesc'),
            ]); ?>

        </div>

    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadinggeneral" />
    </div>

</div>