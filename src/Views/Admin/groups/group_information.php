<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?php $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.general.groups')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

    <div class="relative flex h-full gap-5 sm:h-[calc(100vh_-_150px)]">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\components\sidebar'); ?>

        <div class="panel panel-adn h-full flex-1 overflow-auto">
            <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
<?= $this->include('Btw\Core\Views\Admin\components\sidebar_action'); ?>
                <?= form_open(route_to('group-show', $alias), [
                    'id' => 'kt_groups_form_information', 'hx-post' => route_to('group-show', $alias), 'hx-target' => '#informations',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states",  'novalidate' => false, 'data-loading-target' => "#loadinginformation",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="informations" />
                <input type="hidden" name="alias" value="<?= $alias; ?>" />
                <?= $this->include('Btw\Core\Views\Admin\groups\cells\form_cell_information'); ?>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>