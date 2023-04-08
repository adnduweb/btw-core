<!doctype html>
<html lang="en">

<head>
    <?= $viewMeta->render('meta') ?>

    <?= $viewMeta->render('title') ?>

    <?= asset_link('app/css/dist/output.css', 'css') ?>
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
    <!-- https://shreethemes.in/techwind/ -->
</head>

<body class="font-nunito text-base text-black dark:text-white dark:bg-slate-900">

    <aside id="alerts-wrapper" class="hidden">
        {alerts}
    </aside>


    <?= $this->include('Themes\App\_partials\header') ?>


    <div class="container max-w-screen-xl mx-auto">
        <main class="ms-sm-auto px-md-4 py-5">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <?= $this->include('Themes\App\_partials\footer') ?>
    
    <?= $this->include('Themes\App\_partials\switcher') ?>

    <script src="//unpkg.com/alpinejs" defer></script>
    <?= asset_link('app/js/feather.js', 'js') ?>
    <?= asset_link('app/js/app.js', 'js') ?>
    <?= $viewMeta->render('script') ?>
</body>

</html>