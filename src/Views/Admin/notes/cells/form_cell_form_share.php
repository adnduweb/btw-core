<div id="sharenote" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">

    <?= form_open(route_to('note-share-note-modal', $note->getIdentifier()), [
        'id' => 'kt__form_invoice_sharenote',
        'hx-post' => route_to('note-share-note-modal', $note->getIdentifier()),
        'hx-target' => '#sharenote',
        'hx-ext' => "loading-states, event-header",
        'novalidate' => false,
        'data-loading-target' => "#loadingsharenote",
        'data-loading-class-remove' => "hidden"
    ]); ?>

    <div class="px-4 py-5  space-y-6 sm:p-6">


    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
            <div class="flex flex-col">
                <div class="flex flex-row items-center mb-2">
                    <?= theme()->getSVG('admin/images/icons/bonasavoir.svg', 'svg-icon flex-shrink-0 h-6 w-6 mr-2 dark:text-gray-200 text-gray-800 svg-white', true); ?>
                    <span class="font-bold"><?= lang('Btw.attention'); ?>!</span>
                </div>
                <?= lang('Note.actionShareNoteExplain'); ?>
            </div> 
        </div>


        <div class="w-full mb-5 md:mb-0 mt-5">
            <?= view_cell('Btw\Core\Cells\Forms\SelectCell::renderList', [
                'label' => lang('Note.form.date_expiration_url'),
                'name' => 'date_expiration',
                'required' => true,
                'options' => array_flip(config('Btw')->getExpirated),
                'byKey' => true,
                'selected' =>  old('date_expiration') ?? '5 minutes'
            ]); ?>
        </div>

        <?php if(isset($url_signed)) : ?>
            <div class="mt-3 flex flex-row md:flex-col items-center">
                <span id="copyLink"> <?= $url_signed; ?> </span>
                <span class="copyLink" data-clipboard-target="#copyLink">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ltr:mr-2 rtl:ml-2">
                            <path d="M6 11C6 8.17157 6 6.75736 6.87868 5.87868C7.75736 5 9.17157 5 12 5H15C17.8284 5 19.2426 5 20.1213 5.87868C21 6.75736 21 8.17157 21 11V16C21 18.8284 21 20.2426 20.1213 21.1213C19.2426 22 17.8284 22 15 22H12C9.17157 22 7.75736 22 6.87868 21.1213C6 20.2426 6 18.8284 6 16V11Z" stroke="currentColor" stroke-width="1.5"></path>
                            <path opacity="0.5" d="M6 19C4.34315 19 3 17.6569 3 16V10C3 6.22876 3 4.34315 4.17157 3.17157C5.34315 2 7.22876 2 11 2H15C16.6569 2 18 3.34315 18 5" stroke="currentColor" stroke-width="1.5"></path>
                        </svg>

                </span>
            </div>
        <?php endif; ?>


    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.share'), 'loading' => "loadingsharenoter"]) ?>
    </div>
    <?php form_close(); ?>
</div>