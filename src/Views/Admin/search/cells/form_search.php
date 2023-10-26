<?php if (!empty($notes)) : ?>
    <div class="mx-auto py-6">
        <div class="mx-auto max-w-none">
            <div class="overflow-hidden bg-white sm:rounded-lg sm:shadow">

                <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900"><?= lang('Btw.notes'); ?></h3>
                </div>

                <ul role="list" class="divide-y divide-gray-200" ht-boost="true">

                    <?php foreach ($notes as $note) :   ?>

                        <li hx-get="<?= route_to('note-update-line-search', $note->getIdentifier()); ?>" hx-trigger="updateListeNoteItem from:body">
                            <?= $this->setVar('note', $note)->include('Btw\Core\Views\Admin\search\cells\form_search_note_item'); ?> 
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

<?php endif; ?>
