<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?php $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.general.Permissions')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">


    <div class="row justify-content-md-center">

        <div class="col-sm-12 col-lg-8">
            <?= $this->include('Btw\Core\Views\Admin\permissions\table'); ?>
        </div>

    </div>

</div>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>

</script>
<?php $this->endSection() ?>