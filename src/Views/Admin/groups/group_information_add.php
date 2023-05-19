<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>

<x-page-head>Groups </x-page-head>

<x-admin-box>

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <?php if (isset($menu)) : ?>
            <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\sidebar'); ?>
        <?php endif ?>
        
        <div class=" <?php if (isset($menu)) : ?> space-y-6 sm:px-6 lg:col-span-9 lg:px-0  <?php else: ?> space-y-6 sm:px-6 lg:col-span-12 lg:px-0 <?php endif ?>">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('group-add'), [
                    'id' => 'kt_groups_form_information', 'hx-post' => route_to('group-add'), 'hx-target' => '#informations',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadinginformation",
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

</x-admin-box>
<?php $this->endSection() ?>