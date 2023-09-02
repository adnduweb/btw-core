<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.general.settings')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\sidebar'); ?>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
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