<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head tAdd='<?=  lang('Btw.AddBouton', ['rôle']); ?>' lAdd='group-add'> <?= lang('Btw.roles'); ?> </x-page-head>
<x-admin-box collapse=true>
<?= $this->include('Btw\Core\Views\Admin\groups\table'); ?>
</x-admin-box>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>

</script>
<?php $this->endSection() ?>