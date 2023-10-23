<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?php $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.general.company')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\sidebar'); ?>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('settings-company'), [
                    'id' => 'kt_users_form_general', 'hx-post' => route_to('settings-company'), 'hx-target' => '#company', 'hx-swap' => 'none', 'hx-ext' => "loading-states",  'novalidate' => false, 'data-loading-target' => "#loadingcompany",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= '' //csrf_field()
?>
                <input type="hidden" name="section" value="company" />
                <?= $this->include('Btw\Core\Views\Admin\settings\cells\form_cell_company'); ?>
                <?= form_close(); ?>
            </div>

        </div>
    </div>

</div>

</div <?php $this->endSection() ?>