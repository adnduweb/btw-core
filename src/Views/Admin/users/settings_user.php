<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>

<x-page-head>Settings </x-page-head>

<x-admin-box>

    <div class="flex">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\users\sidebar'); ?>

        <div class="flex-1 ltr:pl-6 rtl:pr-6">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('user-current-settings'), [
                    'id' => 'kt_users_form_information', 'hx-post' => route_to('user-current-settings'), 'hx-target' => '#general',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadinginformation",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="general" />
                <?= $this->include('Btw\Core\Views\Admin\users\cells\form_cell_information'); ?>
                <?= form_close(); ?>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2 mb-5">
                <?= $this->include('Btw\Core\Views\Admin\users\cells\form_cell_other_information'); ?>
            </div>

        </div>
    </div>

</x-admin-box>
<?php $this->endSection() ?>