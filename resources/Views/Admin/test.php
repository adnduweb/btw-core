<!doctype html>
<html >

<head>

    <?= $viewMeta->render('meta') ?>
    <?= $viewMeta->render('title') ?>
    <?= csrf_meta() ?>
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
</head>

<body>

    <!-- Main content -->
    <div class="<?= site_offline() ? 'offline' : '' ?>" x-data="{open: false}">
        <div class="flex h-screen overflow-hidden bg-base-100">

            <x-sidebar />


            <div class="flex w-0 flex-1 flex-col overflow-hidden">
                <?= $this->include('_header') ?>

                <?= ''; //$this->include('_stats') 
                ?>

                <main class="relative flex-1 overflow-y-auto px-8 py-6 dark:bg-gray-900 ">
                    <?= $this->renderSection('main') ?>
                </main>
                </main>
            </div>
        </div>

        <div id="alerts-wrapper" class="fixed inset-x-0 mx-auto bottom-5  max-w-xl sm:w-full space-y-5 z-50"></div>

        <?= $this->renderSection('modals') ?>

        <script src="https://unpkg.com/hyperscript.org@0.9.7" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>

        <?= $this->renderSection('scripts') ?>
        <?= $viewMeta->render('script') ?>
        <?= $viewMeta->render('rawScripts') ?>
</body>

</html>