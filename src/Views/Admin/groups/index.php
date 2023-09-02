<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.roles'), 'add' => ['href' => 'group-add', 'text' => lang('Btw.AddBouton', ['rôle'])]]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">
    <?= $this->include('Btw\Core\Views\Admin\groups\table'); ?>
</div>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>

</script>
<?php $this->endSection() ?>