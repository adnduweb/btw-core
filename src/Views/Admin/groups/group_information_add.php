<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?php $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.general.groups')]) ?>

<divs class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

    <div class="relative h-full gap-5 w-full ">

        <div class=" <?php if (isset($menu)) : ?> space-y-6 sm:px-6 lg:col-span-9 lg:px-0  <?php else : ?> space-y-6 sm:px-6 lg:col-span-12 lg:px-0 <?php endif ?>">
            <div class="mt-5 md:mt-0 " data-loading-states>
                <?= form_open(route_to('group-add'), [
                    'id' => 'kt_groups_form_information', 'hx-post' => route_to('group-add'), 'hx-target' => '#informations',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states",  'novalidate' => false, 'data-loading-target' => "#loadinginformation",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <input type="hidden" name="section" value="informations" />
                <input type="hidden" name="alias" value="<?= $alias; ?>" />
                <?= $this->include('Btw\Core\Views\Admin\groups\cells\form_cell_information'); ?>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

</divs>
<?php $this->endSection() ?>