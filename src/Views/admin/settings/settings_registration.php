<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>


<x-page-head>Settings </x-page-head>

<x-admin-box>

    <div class="flex">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\settings\sidebar'); ?>

        <div class="flex-1 ltr:pl-6 rtl:pr-6">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('settings-registration'), [
                    'id' => 'kt_users_form_registration', 'hx-post' => route_to('settings-registration'), 'hx-target' => '#registration',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadingregistration",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="registration" />
                <?= $this->include('Btw\Core\Views\Admin\settings\cells\form_cell_registration'); ?>
                <?= form_close(); ?>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
                <?= form_open(route_to('settings-registration'), [
                    'id' => 'kt_users_form_login', 'hx-post' => route_to('settings-registration'), 'hx-target' => '#login',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc",  'novalidate' => false, 'data-loading-target' => "#loadinglogin",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="login" />
                <?= $this->include('Btw\Core\Views\Admin\settings\cells\form_cell_login'); ?>
                <?= form_close(); ?>
            </div>

        </div>

</x-admin-box>
</div <?php $this->endSection() ?>