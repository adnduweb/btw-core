<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>


<x-page-head>Settings </x-page-head>

<x-admin-box>

    <div class="flex">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\admin\settings\sidebar'); ?>

        <div class="flex-1 ltr:pl-6 rtl:pr-6">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('settings-email'), [
                    'id' => 'kt_users_form_email', 'hx-post' => route_to('settings-email'), 'hx-target' => '#email', 'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc",  'novalidate' => false, 'data-loading-target' => "#loadingemail",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="email" />
                <?= $this->include('Btw\Core\Views\admin\settings\cells\form_cell_email'); ?>
                <?= form_close(); ?>
            </div>

        </div>

</x-admin-box>
</div <?php $this->endSection() ?>