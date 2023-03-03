<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>


<x-page-head>Settings </x-page-head>

<x-admin-box>

    <div class="md:grid md:grid-cols-3 md:gap-6 mb-10">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Général</h3>
                <p class="mt-1 text-sm text-gray-600">
                    This information will be displayed publicly so be careful what you share.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
            <?= form_open(route_to('general-post-settings'), [
                'id' => 'kt_users_form_general', 'hx-post' => route_to('general-post-settings'), 'hx-target' => '#general',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadinggeneral",
                'data-loading-class-remove' => "hidden"
            ]); ?>
            <?= csrf_field() ?>
            <input type="hidden" name="section" value="general" />
            <?= $this->include('Btw\Core\Views\admin\settings\form_cell_general'); ?>
            <?= form_close(); ?>
        </div>
    </div>


    <div class="md:grid md:grid-cols-3 md:gap-6 mb-10">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Date and Time Settings</h3>
                <p class="mt-1 text-sm text-gray-600">
                    This information will be displayed publicly so be careful what you share.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
            <?= form_open(route_to('general-post-settings'), [
                'id' => 'kt_users_form_dateandtime', 'hx-post' => route_to('general-post-settings'), 'hx-target' => '#dateandtime',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadingdateandtime",
                'data-loading-class-remove' => "hidden"
            ]); ?>
            <?= csrf_field() ?>
            <input type="hidden" name="section" value="dateandtime" />
            <?= $this->include('Btw\Core\Views\admin\settings\form_cell_dateandtime'); ?>
            <?= form_close(); ?>
        </div>
    </div>




    <?= form_open(route_to('/admin/settings/general'), ['id' => 'kt_groups_form', 'hx-post' => "/admin/settings/general", 'hx-include' => '[name=' . csrf_token() . ']', 'hx-swap' => 'none', 'novalidate' => false, 'hx-ext' => 'json-enc']); ?>


    <?= form_close(); ?>
</x-admin-box>
</div <?php $this->endSection() ?>