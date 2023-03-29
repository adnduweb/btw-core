<!doctype html>
<html lang="en"><head>
	<?= $viewMeta->render('meta') ?>

    <?= $viewMeta->render('title') ?>

    <?= asset_link('app/css/dist/output.css', 'css') ?>
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
</head>
<body>

    <aside id="alerts-wrapper">
    {alerts}
    </aside>

    <h1 class="text-4xl ml-[5rem] font-bold underline">
    Hello world!
  </h1>

    <div class="container">
        <main class="ms-sm-auto px-md-4 py-5">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <footer class="border-top text-center p-5">
        <div class="environment">
            <p>Page rendered in {elapsed_time} seconds  &hearts;  Environment: <?= ENVIRONMENT ?></p>
        </div>
    </footer>

    <?= asset_link('app/js/app.js', 'js') ?>
    <?= $viewMeta->render('script') ?>
</body></html>
