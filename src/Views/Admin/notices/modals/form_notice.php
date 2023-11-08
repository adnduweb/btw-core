<?= form_open(route_to('notice-edit'), [
    'id' => 'kt_notices_form_infos_tech',
    'hx-post' => route_to('notice-edit'),
    'hx-target' => '#addnotice',
    'hx-ext' => "loading-states, event-header",
    //disable-element
    // 'hx-disable-element' => "#loadingmodaladdinfostech",
    // 'hx-sync' => "closest form:abort",
    'novalidate' => false,
    'data-loading-target' => "#loadingmodaladdinfostech",
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
            'name' => 'name',
            'value' => old('name', $noticeModal->name),
            'lang' => false
        ]); ?>

    </div>

    <div class="w-full mb-6 md:mb-4">
        <?=
        view_cell('Btw\Core\Cells\Forms\TextAreaCell::renderList', [
            'label' => lang('Form.general.content'),
            'name' => 'description',
            'value' => esc(old('description', $noticeModal->description ?? null)),
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
<div class="px-4 py-3 text-right sm:px-6 bg-gray-100 dark:bg-gray-700 rounded-b-md">
    <input type="hidden" name="lang" value="<?= service('language')->getLocale(); ?>" />
    <input type="hidden" name="company_id" value="0" />
    <input type="hidden" name="user_id" value="0" />
    <?php if (!empty($noticeModal->getIdentifier())) : ?>
        <input type="hidden" name="id" value="<?= $noticeModal->getIdentifier(); ?>" />
    <?php endif; ?>
    <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loadingmodaladdinfostech"]) ?>
    <button type="button" class="inline-flex justify-center cursor-pointer bg-gray-500 text-white active:bg-gray-600 dark:bg-gray-900  font-bold px-4 py-2 text-sm rounded-md shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-in-out duration-1200 transition-all" @click="showNoticeModal = false">
        <?= lang('Btw.close'); ?>
    </button>
</div>
<?= form_close(); ?>