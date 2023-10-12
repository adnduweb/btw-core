<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?= $this->section('title') ?>
<?= lang('Auth.login') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head>Dashboard </x-page-head>

<div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
    <div class="px-5">
        <?= $cells->render();  ?>
    </div>
</div>

<?= $this->endSection() ?>