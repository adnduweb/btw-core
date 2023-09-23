<!doctype html>
<html dir="ltr" data-theme="retro" lang="<?= service('language')->getLocale(); ?>" class="h-full <?= detectBrowser(); ?>" x-data="{theme: localStorage.getItem('_X_theme') || localStorage.setItem('_X_theme', 'system')}" x-init="$watch('theme', val => localStorage.setItem('_X_theme', val))" x-bind:class="{'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)}">

<head>

    <meta name="htmx-config" content='{"historyCacheSize": 0, "refreshOnHistoryMiss": false, "includeIndicatorStyles": false}'>
    <?= $viewMeta->render('meta') ?>
    <title><?= $viewMeta->title() ?></title>
    <?= csrf_meta() ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <?= $viewJavascript->renderLangJson('admin/js/language/' . service('request')->getLocale() . '.json'); ?>
    <?= vite_url('admin'); //vite_admin(['themes/Admin/css/app.css', 'themes/Admin/js/app.js']); 
    ?>

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

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('5c03f2a7361ff4d0c885', {
            cluster: 'eu'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            console.log(JSON.stringify(data));
        });
    </script>


</head>

<!-- debug, loading-states, json-enc, event-header -->
<!-- hx-headers='{"X-Theme": "admin"}' -->

<body hx-ext="morph, ajax-header, head-support, preload" hx-history="false" hx-indicator="#progress" class="h-full antialiased font-sans bg-slate-100 <?= detectAgent(); ?>" x-data="{ modelOpen: false, showDeleteModal: false, showAuthDisplayDataModal: false }" @keydown.escape="showModal = false">

    <!-- Main content -->
    <main class="<?= site_offline() ? 'offline' : '' ?>" x-data="{open: false}">
        <div class="flex h-screen overflow-hidden bg-base-100" x-data="{isSidebarExpanded: <?= (service('settings')->get('Btw.isSidebarExpanded', 'user:' . user_id()) == true) ? 'true' : 'false'; ?>}">

            <?= view_cell('Btw\Core\Cells\Core\AdminSidebar'); ?>

            <div class="flex w-0 flex-1 flex-col overflow-hidden">
                <?= $this->include('_header') ?>

                <div id="progress" class="progress">
                    <div class="indeterminate"></div>
                </div>
                <main class="relative flex-1 overflow-y-auto px-4 md:px-8 py-6 dark:bg-gray-900">
                    <?= $this->renderSection('main') ?>
                </main>

            </div>
        </div>

        <div id="alerts-wrapper" class="fixed inset-x-0 mx-auto bottom-5  max-w-xl sm:w-full space-y-5 z-50"></div>

        <?= $this->renderSection('modals') ?>
        <?= $this->include('partials/modal-delete') ?>
        <?= $this->include('partials/modal-auth-display-data') ?>

        <!-- BUY ME A BEER AND HELP SUPPORT OPEN-SOURCE RESOURCES -->
        <div class="flex items-end justify-end fixed bottom-0 right-0 mb-4 mr-4 z-10">
            <div>
                <a title="Buy me a beer" href="#" target="_blank" class="block w-16 h-16 rounded-full transition-all shadow hover:shadow-lg transform hover:scale-110 hover:rotate-12">
                    <img class="object-cover object-center w-full h-full rounded-full" src="https://i.pinimg.com/originals/60/fd/e8/60fde811b6be57094e0abc69d9c2622a.jpg" />
                </a>
            </div>
        </div>


        <?= $this->include('_notifications') ?>

        <?= $this->include('_modalsLogout') ?>

        <?= $viewJavascript->render(); ?>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment-with-locales.min.js"></script>
        <script src="https://unpkg.com/hyperscript.org@0.9.8" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpine-collective/alpine-magic-helpers@0.3.x/dist/index.js"></script>
        <?= $this->renderSection('scriptsUrl') ?>

    </main>

    {CustomEvent}

    <?= $this->renderSection('scripts') ?>
    <?= $viewMeta->render('script') ?>
    <?= $viewMeta->render('rawScripts') ?>
</body>

</html>