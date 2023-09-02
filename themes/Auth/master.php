<!doctype html>
<html dir="ltr" data-theme="retro" lang="<?= service('language')->getLocale(); ?>">
    <head>
    <?= $viewMeta->render('title') ?>
    <?= csrf_meta() ?>
    <?= $viewMeta->render('meta') ?>
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
    <?= $viewJavascript->renderLangJson('admin/js/language/'.service('request')->getLocale().'.json'); ?>
    <?=  vite(['themes/Admin/css/app.css', 'themes/Admin/js/app.js']); ?>
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
