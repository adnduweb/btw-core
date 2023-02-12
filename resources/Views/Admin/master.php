<!doctype html>
<html lang="en"><head>

    <?= $viewMeta->render('meta') ?>

    <?= $viewMeta->render('title') ?>

    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
</head>
<body>


<?php if (site_offline()) : ?>
    <!-- <div class="alert alert-secondary alert-offline">
        Site is currently offline. Enable it
        <a href="<?= site_url(ADMIN_AREA .'/settings/general') ?>">here</a>.
    </div> -->
<?php endif ?>

<div class="main <?= site_offline() ? 'offline' : '' ?>" x-data="{open: true}" >
    <div class="h-100 d-flex align-items-stretch">
        <nav id="sidebars" class="sidebar md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6" x-bind:class="{ 'collapsed': ! open }">
            <div class="sidebar-wrap  h-100 position-relative">
                <x-sidebar />

                <div class="nav-item position-absolute bottom-0 w-100">
                    <a href="#" class="nav-link sidebar-toggle" @click="open = !open">
                        <i class="fas fa-angle-double-left"></i>
                        <span>Collapse sidebar</span>
                    </a>
                </div>
            </div>
        </nav>

        <main class="relative md:ml-64 bg-blueGray-100">
            <?= $this->include('_header') ?>

            <?= $this->include('_stats') ?>

            <div class="px-md-4 vh-100 pt-50">
                <?= $this->renderSection('main') ?>
            </div>
        </main>
    </div>
</div>

<?= $this->renderSection('scripts') ?>
<?= $viewMeta->render('script') ?>
<?= $viewMeta->render('rawScripts') ?>
</body></html>
