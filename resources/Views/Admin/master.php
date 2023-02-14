<!doctype html>
<html lang="<?= service('request')->getLocale(); ?>" class="h-full <?= detectBrowser(); ?>" x-cloak x-data="{ theme: $persist('light') }" x-bind:class="{ 'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) }">

<head>

    <?= $viewMeta->render('meta') ?>

    <?= $viewMeta->render('title') ?>

    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
</head>

<body x-data class="h-full antialiased font-sans bg-slate-100">

    <aside id="alerts-wrapper">
        {alerts}
    </aside>



    <!-- Main content -->
    <div class="<?= site_offline() ? 'offline' : '' ?>" x-data="{open: false}">
        <div class="h-100 d-flex align-items-stretch">

            <x-sidebar />

            <div class="md:pl-20 lg:pl-64 flex flex-col flex-1">

                <main id="main" class="flex-1">
                    <?= $this->include('_header') ?>

                    <?= $this->include('_stats') ?>

                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 pt-50 mt-50 -m-24">
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

    <?= $this->renderSection('scripts') ?>
    <?= $viewMeta->render('script') ?>
    <?= $viewMeta->render('rawScripts') ?>
</body>

</html>