<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?php $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' =>   lang('Btw.general.edit') . ' : ' . ucfirst($user->last_name) . ' ' . ucfirst($user->first_name)]) ?>

    <div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

        <div class="relative flex h-full gap-5 sm:h-[calc(100vh_-_150px)]">
            <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\components\sidebar'); ?>

            <div class="panel panel-adn h-full flex-1 overflow-auto">
                <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
                    <?= $this->include('Btw\Core\Views\Admin\components\sidebar_action'); ?>
                    <?= form_open(route_to('user-only-browser', $user->id), [
                        'id' => 'kt_users_form_browser', 'hx-post' => route_to('user-only-browser', $user->id), 'hx-target' => '#general',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states",  'novalidate' => false, 'data-loading-target' => "#loadingbrowser",
                        'data-loading-class-remove' => "hidden"
                    ]); ?>
                    <?= csrf_field() ?>
                    <input type="hidden" name="section" value="browser" />
                    <?= $this->include('Btw\Core\Views\Admin\users\only\cells\form_cell_browser'); ?>
                    <?= form_close(); ?>
                </div>

            </div>
        </div>

    </div>
<?php $this->endSection() ?>