<div id="informations" class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

        <div class="col-span-6 sm:col-span-4">

            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'text',
                'label' => lang('Form.general.title'),
                'name' => 'title',
                'value' => esc(old('title', $group['title'] ?? null))
            ]); ?>
        </div>


        <div class="col-span-6 sm:col-span-4">
            <?= view_cell('Btw\Core\Cells\Forms\TextAreaCell::renderList', [
                'label' => lang('Form.general.description'),
                'name' => 'description',
                'value' =>   esc(old('description', $group['description'] ?? null)),
                'description' => 'Brief description for your profile. URLs are hyperlinked.'
            ]); ?>
        </div>

    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
    <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loading"]) ?>
    </div>
</div> 