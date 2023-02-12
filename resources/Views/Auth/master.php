<!doctype html>
<html lang="en"><head>
	<?= $viewMeta->render('meta') ?>

    <?= $viewMeta->render('title') ?>

    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
</head>
<body class="bg-gray-100">

<div class="container-fluid main">
    <main class="ms-sm-auto px-md-4">
        <?= $this->renderSection('main') ?>
    </main>
</div>


<?= $this->renderSection('scripts') ?>
<?= $viewMeta->render('script') ?>
</body></html>
