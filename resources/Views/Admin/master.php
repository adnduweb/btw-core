<!doctype html>
<html lang="<?= service('request')->getLocale(); ?>" class="h-full <?= detectBrowser(); ?>" x-cloak x-data="{theme: localStorage.getItem('_X_theme') || localStorage.setItem('_X_theme', 'system')}" x-init="$watch('theme', val => localStorage.setItem('_X_theme', val))" x-bind:class="{'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)}">

<head>

    <?= $viewMeta->render('meta') ?>
    <?= $viewMeta->render('title') ?>
    <?= csrf_meta() ?>
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
</head>

<body hx-ext="morph" hx-ext="ajax-header" hx-headers='{"<?= csrf_token() ?>": "<?= csrf_hash() ?>", "X-Theme": "admin"}' class="h-full antialiased font-sans bg-slate-100">

    <!-- Main content -->
    <div class="<?= site_offline() ? 'offline' : '' ?>" x-data="{open: false}">
        <div class="h-100 d-flex align-items-stretch">

            <x-sidebar />

            <div class="md:pl-20 lg:pl-64 flex flex-col flex-1">

                <main id="main" class="flex-1">
                    <?= $this->include('_header') ?>

                    <?= $this->include('_stats') ?>

                    <div class=" mx-auto px-4 sm:px-6 md:px-10 pt-50 mt-50 -m-24">
                        <div class="flex flex-wrap mt-4">
                            <div class="w-full mb-12 px-4">
                                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-slate-100">
                                    <?= $this->renderSection('main') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <x-message />
    <div id="alerts-wrapper" class="fixed inset-x-0 mx-auto bottom-5  max-w-xl sm:w-full space-y-5 z-50"></div>





    <script src="https://unpkg.com/hyperscript.org@0.9.7" crossorigin="anonymous"></script>

    <?= $this->renderSection('scripts') ?>
    <?= $viewMeta->render('script') ?>
    <?= $viewMeta->render('rawScripts') ?>
</body>

</html>