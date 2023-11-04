<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?php $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.general.settings')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

    <div class="relative flex h-full gap-5 sm:h-[calc(100vh_-_150px)]">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\components\sidebar'); ?>

        <div class="panel panel-adn h-full flex-1 overflow-auto">
            <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
<?= $this->include('Btw\Core\Views\Admin\components\sidebar_action'); ?>
                <?= form_open(route_to('settings-passwords'), [
                    'id' => 'kt_users_form_password', 'hx-post' => route_to('settings-passwords'), 'hx-target' => '#password',  'hx-swap' => 'none', 'hx-ext' => "loading-states",  'novalidate' => false, 'data-loading-target' => "#loadingpassword",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="password" />
                <?= $this->include('Btw\Core\Views\Admin\settings\cells\form_cell_password'); ?>
                <?= form_close(); ?>
            </div>

        </div>

    </div>
</div>
</div <?php $this->endSection() ?>