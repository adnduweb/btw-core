<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>


<x-page-head>Settings </x-page-head>

<x-admin-box>

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\sidebar'); ?>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('settings-avatar'), [
                    'id' => 'kt_users_form_avatar', 'hx-post' => route_to('settings-avatar'), 'hx-target' => '#avatar', 'hx-ext' => "loading-states",  'novalidate' => false, 'data-loading-target' => "#loadingavatar",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= ''; //csrf_field() ?>
                <input type="hidden" name="section" value="avatar" />
                <?= $this->include('Btw\Core\Views\Admin\settings\cells\form_cell_avatar'); ?>
                <?= form_close(); ?>
            </div>

        </div>

</x-admin-box>
<?php $this->endSection() ?>


<?php $this->section('scripts') ?>
<script>
    document.body.addEventListener("updateAvatar",
        function(evt) {
            console.info("avatar updated")
        })
</script>
<?php $this->endSection() ?>