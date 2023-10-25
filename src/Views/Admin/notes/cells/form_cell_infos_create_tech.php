<?= form_open(route_to('note-create'), [
    'id' => 'kt_notes_form_create',
    'hx-post' => route_to('note-create'),
    'hx-target' => '#addnote',
    'hx-ext' => "loading-states, event-header",
    //disable-element
    // 'hx-disable-element' => "#loadingmodaladdnote",
    // 'hx-sync' => "closest form:abort",
    'novalidate' => false,
    'data-loading-target' => "#loadingmodaladdnote",
    'data-loading-class-remove' => "hidden"
]); ?>
<?= '' //csrf_field()
?>
<input type="hidden" name="section" value="infostech" />

<div class=" p-8">

    <div class="w-full mb-6 md:mb-4">

        <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
            'type' => 'text',
            'label' => lang('Form.address.titre'),
            'name' => 'titre',
            'value' => old('titre', $noteModal->titre),
            'lang' => false
        ]); ?>

    </div>

    <div class="w-full mb-6 md:mb-4">
        <?=
        view_cell('Btw\Core\Cells\Forms\TextAreaCell::renderList', [
            'label' => lang('Form.general.content'),
            'name' => 'content',
            'value' => esc(old('content', $noteModal->getContentPrep() ?? null)),
            'lang' => false,
            'wysiwyg' => 'simplemde'
        ]);
?>
    </div>

    <?php if (isset($validation)) : ?>
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif ?>
</div>
<div class="px-4 py-3 text-right sm:px-6 bg-gray-100 rounded-b-md">
    <?php if (!empty($noteModal->getIdentifier())) : ?>
        <input type="hidden" name="id" value="<?= $noteModal->getIdentifier(); ?>" />
    <?php endif; ?>
    <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loadingmodaladdnote"]) ?>
    <button type="button" class="inline-flex justify-center cursor-pointer bg-gray-500 text-white active:bg-gray-600 dark:bg-gray-900  font-bold px-4 py-2 text-sm rounded-md shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-in-out duration-1200 transition-all" @click="showNoteModal = false">
        <?= lang('Btw.close'); ?>
    </button>
</div>
<?= form_close(); ?>