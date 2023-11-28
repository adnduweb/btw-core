<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?= $this->section('title') ?>
<?= lang('Btw.Dashboard') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.Dashboard')]) ?>

<?= $this->include('Btw\Core\Views\Admin\notices\display'); ?>


<!-- <div
                        id="heartbeat"
                        hx-ext="ws"
                        ws-connect="/admin1198009422/ws/notifications/stream/list"
                        hx-swap-oob="beforeend"
                    >
                        <h3>Messages</h3>
                    </div> -->


<?= $cells->render();  ?>
<?= $cells->scripts();  ?>
<?= $this->endSection() ?> 

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>