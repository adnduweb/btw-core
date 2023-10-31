<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?= $this->section('title') ?>
<?= lang('Btw.Dashboard') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.Dashboard')]) ?>
<?= $cells->render();  ?>
<?= $this->endSection() ?> 

<?= $this->section('scripts') ?>
<?= $cells->scripts();  ?>
<?= $this->endSection() ?>