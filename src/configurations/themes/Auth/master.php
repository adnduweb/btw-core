<!doctype html>
<html dir="ltr" data-theme="retro" lang="<?= service('language')->getLocale(); ?>">

<head>
    <meta name="htmx-config" content='{"historyCacheSize": 0, "refreshOnHistoryMiss": false}'>
    <?= $viewMeta->render('title') ?>
    <?= csrf_meta() ?>
    <?= $viewMeta->render('meta') ?>
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <?= $viewJavascript->renderLangJson('admin/js/lang/' . service('request')->getLocale() . '.json'); ?>
    <?= vite_tags(['themes/admin/css/app.css', 'themes/admin/js/app.js'], 'admin') ?>

    <style>
        .htmx-indicator {
            opacity: 0;
            transition: opacity 500ms ease-in;
        }

        .htmx-request .htmx-indicator {
            opacity: 1
        }

        .htmx-request.htmx-indicator {
            opacity: 1
        }
    </style>

</head>

<!-- hx-target="#main" hx-select="#main" hx-swap="outerHTML" -->

<body hx-ext="morph, ajax-header, head-support" hx-history="false" hx-indicator="#progress" class="bg-gray-100 <?= detectAgent(); ?>">

    <main id="main">
        <div id="progress" class="progress">
            <div class="indeterminate"></div>
        </div>

        <div class="container-fluid main">
            <main class="ms-sm-auto px-md-4">
                <?= $this->renderSection('main') ?>
            </main>
        </div>

        <div id="alerts-wrapper" class="fixed inset-x-0 mx-auto bottom-5  max-w-xl sm:w-full space-y-5 z-50"></div>

        <?= $this->include('_notifications') ?>

        <?= $viewJavascript->render(); ?>
        <?= asset_link('admin/js/moment.min.js', 'js') ?>
        <?= asset_link('admin/js/moment-with-locales.min.js', 'js') ?>
        <?= asset_link('admin/js/_hyperscript.min.js', 'js') ?>
        <?= asset_link('admin/js/zxcvbn.js', 'js') ?>
        <script src="https://cdn.jsdelivr.net/gh/alpine-collective/alpine-magic-helpers@0.3.x/dist/index.js"></script>
        <?= $this->renderSection('scriptsUrl') ?>

    </main>

    <?= $this->renderSection('scripts') ?>
    <?= $viewMeta->render('script') ?>
    <?= $viewMeta->render('rawScripts') ?>
</body>

</html>