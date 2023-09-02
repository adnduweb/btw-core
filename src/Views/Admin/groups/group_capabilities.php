<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.general.groups')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\sidebar'); ?>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('group-capabilities', $alias), [
                    'id' => 'kt_groups_form_capabilities', 'hx-post' => route_to('group-capabilities', $alias), 'hx-target' => '#capabilities',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states",  'novalidate' => false, 'data-loading-target' => "#loadingcapabilities",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="capabilities" />
                <input type="hidden" name="alias" value="<?= $alias; ?>" />
                <?= $this->include('Btw\Core\Views\Admin\groups\cells\form_cell_capabilities'); ?>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>