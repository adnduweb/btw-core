<div class="px-4 py-4 sm:px-6">
    <div class="flex items-center justify-between">
        <div class="truncate text-sm font-medium text-indigo-600"> <?= $note->titre; ?></div>
        <div class="ml-2 flex flex-shrink-0">
            <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">F <?= $note->created_at; ?></span>
        </div>
    </div>
</div>
<!-- <a  x-on:click="showSlideOver = false" href="<?= route_to('notes-list'); ?>" class="block hover:bg-gray-50"> -->
<div class="mb-5" x-data="{ active: 1 }">
    <div class="space-y-2 font-semibold">
        <div class="rounded">
            <button type="button" class="p-4 w-full flex items-center text-dark dark:bg-[#1b2e4b]" :class="{'!text-primary' : active === 3}" x-on:click="active === 3 ? active = null : active = 3">Détail
            </button>
            <div x-cloak x-show="active === 3" x-collapse>
                <div class="p-4 text-[13px]">
                <?php if ($note->confirm_auth_content && ((time() - $note->confirm_auth_content['expire']) < config('Btw')->dataAskAuthExpiration) /* 1 heure */) : ?>
                    <?= \Michelf\Markdown::defaultTransform($note->getContentPrepFront()); ?>
                <?php else : ?>
                    <?= $note->removeAskAuthContent($note->confirm_auth_content);?>
                    <?= view_cell('Btw\Core\Cells\Datatable\DatatableAskAuth', ['row' => $note, 'hxTrigger' => 'updateListeNoteItem', 'controller' => 'note', 'method' => 'ajaxDatatable']); ?> 
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="flex justify-center mb-2">
    <a target="_blank"  x-on:click="showSlideOver = false" href="<?= route_to('notes-list'); ?>" class="ml-2 inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 transition sm:text-sm"> <?= lang('Btw.viewDetail'); ?> </a>
</div>