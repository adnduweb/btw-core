<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?= $this->section('title') ?>
<?= lang('Btw.login') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.noticesList')]) ?>
<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

    <div class="row justify-content-md-center">

        <div class="col-sm-12 col-lg-8">
            <?= $this->include('Btw\Core\Views\Admin\notices\cells\list_notices'); ?>
        </div>

    </div>
</div>


<?= $this->endSection() ?>