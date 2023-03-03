<!doctype html>
<html data-theme="retro" lang="<?= service('request')->getLocale(); ?>" class="h-full <?= detectBrowser(); ?>" x-cloak x-data="{theme: localStorage.getItem('_X_theme') || localStorage.setItem('_X_theme', 'system')}" x-init="$watch('theme', val => localStorage.setItem('_X_theme', val))" x-bind:class="{'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)}">

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
        <div class="flex h-screen overflow-hidden bg-base-100">

            <x-sidebar />

           
                <div class="flex w-0 flex-1 flex-col overflow-hidden">
                    <?= $this->include('_header') ?>

                    <?= ''; //$this->include('_stats') 
                    ?>

                    <main class="relative flex-1 overflow-y-auto px-8 py-6">
                        <?= $this->renderSection('main') ?>
                    </main>
                </main>
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