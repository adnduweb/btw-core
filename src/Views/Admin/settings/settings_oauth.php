<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>

<x-page-head>Settings </x-page-head>

<x-admin-box>

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\sidebar'); ?>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('settings-oauth'), [
                    'id' => 'kt_users_form_general', 'hx-post' => route_to('settings-oauth'), 'hx-target' => '#oauth',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadingoauth",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="oauth" />
                <?= $this->include('Btw\Core\Views\Admin\settings\cells\form_cell_oauth'); ?>
                <?= form_close(); ?>
            </div>
            
        </div>
    </div>

</x-admin-box>
</div <?php $this->endSection() ?>