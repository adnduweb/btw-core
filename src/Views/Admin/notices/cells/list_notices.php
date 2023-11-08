<div id="notices" class="sm:overflow-hidden" hx-get="<?= route_to('notice-list'); ?>" hx-trigger="updateListNotice from:body">
    <div class="px-4 py-5 space-y-6 sm:p-6">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">
                    <?= lang('Btw.cellh3.notices'); ?>
                </h1>
                <p class="mt-2 text-sm text-gray-700">
                    <?= lang('Btw.cellh3.noticeDesc'); ?>
                </p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button type="button" class="inline-flex justify-center cursor-pointer bg-blue-500 text-white active:bg-blue-600 dark:bg-gray-800 font-bold px-4 py-2 text-sm rounded-md shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-in-out duration-1200 transition-all" hx-get="<?= route_to('notice-update', 0); ?>" hx-target="#addnotice" x-on:click="$dispatch(`modalcomponent`, {showNoticeModal: true})" class=""><?= lang('Btw.addNotice'); ?></button>
            </div>
        </div>
        <?php if (empty($notices)) : ?>

            <div class="mx-auto max-w-7xl text-center mt-10">
                <h2 class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Liste des notices</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">Aucune notice de créer</p>
            </div>
        <?php else : ?>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>

                            <tr class="py-3.5 pl-4 pr-3 text-left sm:pl-0">
                                    <?php $i = 0;
            foreach ($columns as $column) : ?>
                                        <?php if ($column['name'] == 'selection') : ?>
                                            <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                    <input class="form-check-input allCheck w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" type="checkbox" data-kt-check="true" data-kt-check-target="#notices .form-check-input" value="1" />
                                                </div>
                                            </th>
                                        <?php else : ?>
                                            <?php if (isset($column['orderable'])) : ?>
                                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-normal"><?= $column['header']; ?></th>
                                            <?php else : ?>
                                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-normal"> <?= $column['header']; ?></th>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php $i++;
            endforeach; ?>
                                </tr>


                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($notices as $notice) : ?>
                                    <?= $this->setData(['notice' => $notice])->include('Btw\Core\Views\Admin\notices\tables\table_row_notices'); ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->section('modals') ?>

<?= view_cell('Btw\Core\Cells\Modal::renderList', [
    'type' => 'showNoticeModal',
    'name' => 'notice',
    'title' => lang('Form.modal.addOrdEditNotice'),
    'identifier' => 'addnotice',
    'notice' => $notice ?? null,
    'noticeModal' => $noticeModal ?? null,
    'containerFull' => true,
    'view' => 'Btw\Core\Views\Admin\notices\cells\form_cell_form_notice'
]); ?>


<?php $this->endSection() ?>

<?php $this->section('styles') ?>
    <?= view_cell('Btw\Core\Cells\Forms\TextAreaCell::scripts', ['wysiwyg' => 'simplemde']); ?>
<?php $this->endSection() ?>