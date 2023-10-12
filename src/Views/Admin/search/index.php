<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?= $this->section('title') ?><?= lang('Btw.Search') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head>
    <h2><?= lang('Btw.Search') ?></h2>
</x-page-head>

<x-admin-box>

    <?= $cells->render(); ?>

</x-admin-box>
<?php $this->endSection() ?>