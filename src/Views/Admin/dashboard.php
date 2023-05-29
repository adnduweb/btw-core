<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>
<?= lang('Auth.login') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head>Dashboard </x-page-head>

<x-admin-box>
    <?= $cells->render(); ?>
</x-admin-box>

<?= $this->endSection() ?>