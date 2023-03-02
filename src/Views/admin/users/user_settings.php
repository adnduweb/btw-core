<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>
<x-page-head>
    <x-module-title><i class="fas fa-user"></i> Users</x-module-title>
    <h2>Settings</h2>
</x-page-head>

<x-admin-box>



    <div class="md:grid md:grid-cols-3 md:gap-6 mb-10">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">REGISTRATION</h3>
                <p class="mt-1 text-sm text-gray-600">
                    This information will be displayed publicly so be careful what you share.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
            <?= form_open(route_to('user-settings-save'), [
                'id' => 'kt_users_form_registration', 'hx-post' => route_to('user-settings-save'), 'hx-target' => '#registration',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadingregistration",
                'data-loading-class-remove' => "hidden"
            ]); ?>
            <?= csrf_field() ?>
            <input type="hidden" name="section" value="registration" />
            <?= $this->include('Btw\Core\Views\admin\users\form_cell_registration'); ?>
            <?= form_close(); ?>
        </div>
    </div>

    <div class="md:grid md:grid-cols-3 md:gap-6 mb-10">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">LOGIN</h3>
                <p class="mt-1 text-sm text-gray-600">
                    This information will be displayed publicly so be careful what you share.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
            <?= form_open(route_to('user-settings-save'), [
                'id' => 'kt_users_form_login', 'hx-post' => route_to('user-settings-save'), 'hx-target' => '#login',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc",  'novalidate' => false, 'data-loading-target' => "#loadinglogin",
                'data-loading-class-remove' => "hidden"
            ]); ?>
            <?= csrf_field() ?>
            <input type="hidden" name="section" value="login" />
            <?= $this->include('Btw\Core\Views\admin\users\form_cell_login'); ?>
            <?= form_close(); ?>
        </div>
    </div>

    <div class="md:grid md:grid-cols-3 md:gap-6 mb-10">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">PASSWORDS</h3>
                <p class="mt-1 text-sm text-gray-600">
                    This information will be displayed publicly so be careful what you share.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
            <?= form_open(route_to('user-settings-save'), [
                'id' => 'kt_users_form_password', 'hx-post' => route_to('user-settings-save'), 'hx-target' => '#password',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc",  'novalidate' => false, 'data-loading-target' => "#loadingpassword",
                'data-loading-class-remove' => "hidden"
            ]); ?>
            <?= csrf_field() ?>
            <input type="hidden" name="section" value="password" />
            <?= $this->include('Btw\Core\Views\admin\users\form_cell_password'); ?>
            <?= form_close(); ?>
        </div>
    </div>

    <div class="md:grid md:grid-cols-3 md:gap-6 mb-10">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">AVATARS</h3>
                <p class="mt-1 text-sm text-gray-600">
                    This information will be displayed publicly so be careful what you share.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
            <?= form_open(route_to('user-settings-save'), [
                'id' => 'kt_users_form_avatar', 'hx-post' => route_to('user-settings-save'), 'hx-target' => '#avatar', 'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc",  'novalidate' => false, 'data-loading-target' => "#loadingavatar",
                'data-loading-class-remove' => "hidden"
            ]); ?>
            <?= csrf_field() ?>
            <input type="hidden" name="section" value="avatar" />
            <?= $this->include('Btw\Core\Views\admin\users\form_cell_avatar'); ?>
            <?= form_close(); ?>
        </div>
    </div>






</x-admin-box>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>

document.body.addEventListener("updateAvatar",
    function (evt) {
        console.info("avatar updated")
    })

</script>
<?php $this->endSection() ?>