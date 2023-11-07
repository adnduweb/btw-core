<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?= $this->section('title') ?>
<?= lang('Btw.Dashboard') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.Dashboard')]) ?>

<!-- <div
                        id="heartbeat"
                        hx-ext="ws"
                        ws-connect="/admin1198009422/ws/notifications/stream/list"
                        hx-swap-oob="beforeend"
                    >
                        <h3>Messages</h3>
                    </div> -->


<?= $cells->render();  ?>
<?= $this->endSection() ?> 

<?= $this->section('scripts') ?>
<?= $cells->scripts();  ?>

<!-- <script>

var server = new WebSocketServer();
server.on('connection', function (socket) {
  // Do something and then
  socket.close(); //quit this connection
});

</script> -->

<script>

var conn = new WebSocket('ws://localhost:8282/echo');
conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e){ console.log(e.data); };
conn.onopen = () => conn.send('hello');

</script>

<?= $this->endSection() ?>