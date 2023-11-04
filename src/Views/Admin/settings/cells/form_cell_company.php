<div id="company" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5  space-y-6 sm:p-6">


    <div class="row">
            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'number',
                'label' => lang('Form.general.seuilMEArtisans'),
                'name' => 'seuilMEArtisans',
                'value' => old('seuilMEArtisans', setting('Btw.seuilMEArtisans')),
                'description' => lang('Form.general.seuilMEArtisansDesc'),
            ]); ?>
        </div>

        <div class="row">
            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'number',
                'label' => lang('Form.general.seuilMECommercants'),
                'name' => 'seuilMECommercants',
                'value' => old('seuilMECommercants', setting('Btw.seuilMECommercants')),
                'description' => lang('Form.general.seuilMECommercantsDesc'),
            ]); ?>
        </div>


    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loadingcompany"]) ?>
    </div>

</div>