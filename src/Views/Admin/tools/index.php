<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?= $this->section('title') ?><?= lang('Btw.Activity') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' =>   lang('Btw.general.systemInfo')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">
    <div class="overflow-x-auto rounded-lg shadow overflow-y-auto relative pt-5" hx-boost="false">
        <fieldset class="px-4 py-5 sm:px-6 ">
            <legend class="text-base font-semibold leading-6 m-0 dark:text-white-dark">Server Information</legend>

            <div class="col-12 col-sm-6">
                <table class="min-w-full divide-y divide-gray-300">
                    <tbody class="divide-y divide-gray-200">
                        <tr scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">PHP Version</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500"><?= PHP_VERSION ?></td>
                        </tr>
                        <tr scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">CodeIgniter Version</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500"><?= $ciVersion ?></td>
                        </tr>
                        <tr scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">SQL Engine</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500"><?= $dbDriver . ' ' . $dbVersion ?></td>
                        </tr>
                        <tr scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">Server OS</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500"><?= php_uname('s') ?> <?= php_uname('r') ?> (<?= php_uname('m') ?>)</td>
                        </tr>
                        <tr scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">Server Load</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500"><?= $serverLoad !== null ? number_format($serverLoad, 1) : 'Unknown' ?></td>
                        </tr>
                        <tr scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">Max Upload</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500"><?= (int) (ini_get('upload_max_filesize')) ?>M</td>
                        </tr>
                        <tr scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">Max POST</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500"><?= (int) (ini_get('post_max_size')) ?>M</td>
                        </tr>
                        <tr scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">Memory Limit</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500"><?= (int) (ini_get('memory_limit')) ?>M</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </fieldset>

        <fieldset class="px-4 py-5 sm:px-6 ">
            <legend class="text-base font-semibold leading-6 m-0 dark:text-white-dark">PHP Info</legend>

            <a href="<?= route_to('sys-phpinfo'); ?>" class="rounded bg-gray-700 py-1 px-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600" target="_blank">View PHP Info</a>
        </fieldset>

        <fieldset class="px-4 py-5 sm:px-6 ">
            <legend class="text-base font-semibold leading-6 m-0 dark:text-white-dark">Filesystem</legend>

            <div class="col-12 col-sm-6">
                <table class="min-w-full divide-y divide-gray-300">
                    <tbody class="divide-y divide-gray-200">
                        <tr scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500" colspan="3"><i class="far fa-file"></i> .env</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                <?php if (is_file(ROOTPATH . '.env')) : ?>
                                    <span class="text-green-700">present</span>
                                <?php else : ?>
                                    <span class="text-red-700">missing</span>
                                <?php endif ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500" colspan="3"><i class="far fa-folder"></i> /writeable</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                <?php if (is_really_writable(WRITEPATH)) : ?>
                                    <span class="text-green-700">writeable</span>
                                <?php else : ?>
                                    <span class="text-red-700">not writeable</span>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php foreach (get_dir_file_info(WRITEPATH, true) as $folder => $info) : ?>
                            <tr class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                                <?php if (is_dir(WRITEPATH . $folder)) : ?>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500" colspan="3">
                                        <i class="fas fa-minus"></i>
                                        <i class="far fa-folder"></i>
                                        <?= trim($folder, ' /') ?>
                                    </td>
                                <?php else : ?>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        <i class="fas fa-minus"></i>
                                        <i class="far fa-file"></i>
                                        <?= trim($folder, ' /') ?>
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        <?= lang('Bonfire.lastModified') ?>: <?= strftime('%c', $info['date']) ?></td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        <?= lang('Bonfire.fileSize') ?>: <?= number_to_size($info['size']) ?>
                                    </td>
                                <?php endif ?>
                                <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                    <?php if (is_really_writable(WRITEPATH . $folder)) : ?>
                                        <span class="text-green-700">writeable</span>
                                    <?php else : ?>
                                        <span class="text-red-700">not writeable</span>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </fieldset>
    </div>
</div>
<?php $this->endSection() ?>