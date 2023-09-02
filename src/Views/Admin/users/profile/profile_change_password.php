<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.general.editProfile')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

<div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
<?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\sidebar'); ?>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0" x-data="appGeneratePassword()" x-init="generatePassword()">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('user-change-password'), [
                    'id' => 'kt_users_form_changepassword', 'hx-post' => route_to('user-change-password'), 'hx-target' => '#changepassword',  'hx-ext' => "loading-states",  'novalidate' => false, 'data-loading-target' => "#loadingchangepassword",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="passwords" />
                <?= $this->include('Btw\Core\Views\Admin\users\profile\cells\form_cell_changepassword'); ?>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

</div>
<?php $this->endSection() ?>