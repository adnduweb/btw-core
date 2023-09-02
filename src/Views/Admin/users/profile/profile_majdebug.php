<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.general.editProfile')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\sidebar'); ?>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open_multipart(route_to('user-majdebug'), [
                    'id' => 'kt_users_form_information',
                    'hx-post' => route_to('user-majdebug'),
                    'hx-target' => '#majdebug',
                    'hx-swap' => 'none',
                    'hx-ext' => "loading-states, event-header",
                    'novalidate' => false,
                    'data-loading-target' => "#loadingmajdebug",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= '' //csrf_field() 
                ?>
                <input type="hidden" name="section" value="majdebug" />
                <?= $this->include('Btw\Core\Views\Admin\users\profile\cells\form_cell_majdebug'); ?>
                <?= form_close(); ?>
            </div>

        </div>
    </div>

</div>
<?php $this->endSection() ?>