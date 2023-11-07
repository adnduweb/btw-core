<div id="generalsetting" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5  space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.cellh3.general'); ?></h3>

        <!-- Site Name -->
        <div class="row">
            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'text',
                'label' => lang('Form.general.siteName'),
                'name' => 'siteName',
                'value' => old('siteName', setting('Site.siteName')),
                'description' => lang('Form.general.siteNameDesc'),
            ]); ?>
        </div>

        <div class="row">
            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'text',
                'label' => lang('Form.general.titleNameAdmin'),
                'name' => 'titleNameAdmin',
                'value' => old('titleNameAdmin', setting('Btw.titleNameAdmin')),
                'description' => lang('Form.general.titleNameAdminDesc'),
            ]); ?>
        </div>

        <!-- Site Online? -->
        <div x-data="{ allow_ip: <?= old('siteOnline', setting('Site.siteOnline')) ? 'true' : 'false' ?>}">
            <div class="w-full mb-6 md:mb-0">
                <?= view_cell('Btw\Core\Cells\Forms\SwitchCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Btw.siteOnline'),
                    'name' => 'siteOnline',
                    'value' => '1',
                    'checked' => (old('siteOnline', setting('Site.siteOnline') ?? false)),
                    'description' => lang('Form.general.siteOnlineDesc'),
                    'xNotData' => "true",
                    'xOn' => "allow_ip",
                    'xChange' => "allow_ip = ! allow_ip"
                ]); ?>
            </div>



            <div x-show="allow_ip == false" class="w-full mt-6 mb-6 md:mb-0">
                <?php echo view_cell('Btw\Core\Cells\Forms\TextAreaCell::renderList', [
                    'label' => lang('Form.general.IpAllowed'),
                    'name' =>  'ipAllowed',
                    'value' => (old('siteOnline', setting('Site.ipAllowed') ?? false)),
                    'description' => lang('Form.general.IpAllowedDesc'),
                ]); ?>
                <div id="ipAllowedResult"></div>
            </div>
        </div>

        <div class="row mb-3">
            <?= view_cell('Btw\Core\Cells\Forms\SwitchCell::renderList', [
                'label' => lang('Form.settings.activeMultilangue'),
                'name' => 'activeMultilangue',
                'value' => '1',
                'checked' => (old('activeMultilangue', setting('Site.activeMultilangue') ?? false)),
                'description' => lang('Form.settings.activeMultilangueDescription'),
            ]); ?>
        </div>

        <div class="row">
            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'text',
                'label' => lang('Form.general.BreadcrumbStart'),
                'name' => 'BreadcrumbStart',
                'value' => old('BreadcrumbStart', setting('Site.BreadcrumbStart')),
                'description' => lang('Form.general.BreadcrumbStartDesc'),
            ]); ?>
        </div>

        <div class="row mb-3">
            <?= view_cell('Btw\Core\Cells\Forms\SwitchCell::renderList', [
                'label' => lang('Form.settings.activeWebsocket'),
                'name' => 'activeWebsocket',
                'value' => '1',
                'checked' => (old('activeWebsocket', setting('Btw.activeWebsocket') ?? false)),
                'description' => lang('Form.settings.activeWebsocketDescription'),
            ]); ?>
        </div>

    </div>

    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loadinggeneral"]) ?>
    </div>
</div>

<script type="module">
    $.getJSON('https://api.ipify.org?format=json', function(data) {
        const dialog = document.getElementById('ipAllowedResult')
        if (ipAllowedResult) {
            dialog.innerHTML = '<span class="inline-flex items-center rounded-full bg-indigo-100 px-2 py-1 text-xs font-medium text-indigo-800">Votre addresse ip : ' + data.ip + '</span>';
        }


    });
</script>