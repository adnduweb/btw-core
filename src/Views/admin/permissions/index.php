<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>
<x-page-head>
    <x-module-title><i class="fas fa-user"></i> Permissions</x-module-title>
</x-page-head>

<x-admin-box>

    <div class="row justify-content-md-center">

        <div class="col-sm-12 col-lg-8">
            <?= $this->include('Btw\Core\Views\admin\permissions\table'); ?>
        </div>

    </div>

</x-admin-box>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>

</script>
<?php $this->endSection() ?>