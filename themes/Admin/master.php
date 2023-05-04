<!doctype html>
<html dir="ltr" data-theme="retro" lang="<?= service('language')->getLocale(); ?>"
    class="h-full <?= detectBrowser(); ?>" x-cloak
    x-data="{theme: localStorage.getItem('_X_theme') || localStorage.setItem('_X_theme', 'system')}"
    x-init="$watch('theme', val => localStorage.setItem('_X_theme', val))"
    x-bind:class="{'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)}">

<head>

    <?= $viewMeta->render('meta') ?>
    <?= $viewMeta->render('title') ?>
    <?= csrf_meta() ?>
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <?= $viewJavascript->render(); ?>
    <?= $viewJavascript->renderLangJson('admin/js/language/' . service('request')->getLocale() . '.json'); ?>

    <script type="text/javascript">
        /**
         * ----------------------------------------------------------------------------
         * Javascript Auto Logout in CodeIgniter 4
         * ---------------------------------------------------------------------------
         */
        // Set timeout variables.
        var timoutNow = <?= env('session.expiration'); ?>; // Timeout of 1800000 / 30 mins - time in ms
        var logoutUrl = doudou.base_url + doudou.areaAdmin + '/logout'; // URL to logout page.

        var timeoutTimer;

        // Start timer
        function StartTimers() {
            timeoutTimer = setTimeout("IdleTimeout()", timoutNow);
        }

        // Reset timer
        function ResetTimers() {
            clearTimeout(timeoutTimer);
            StartTimers();
        }

        // Logout user
        function IdleTimeout() {
            console.log('logout')
            window.location = logoutUrl;
        }

    </script>



</head>

<!-- debug -->
<body hx-ext="morph, ajax-header, json-enc" hx-history="false" hx-headers='{"X-Theme": "admin"}' 
    class="h-full antialiased font-sans bg-slate-100" x-data="{ modelOpen: false }">

    <!-- Main content -->
    <main class="<?= site_offline() ? 'offline' : '' ?>" x-data="{open: false}">
        <div class="flex h-screen overflow-hidden bg-base-100"
            x-data="{isSidebarExpanded: <?= (service('settings')->get('Btw.isSidebarExpanded', 'user:' . user_id()) == true) ? 'true' : 'false'; ?>}">

            <x-sidebar />
            <?= '' //$this->include('_sidebar') ?>


            <div class="flex w-0 flex-1 flex-col overflow-hidden">
                <?= $this->include('_header') ?>

                <?= ''; //$this->include('_stats') 
                ?>

                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
                <main class="relative flex-1 overflow-y-auto px-4 md:px-8 py-6 dark:bg-gray-900">
                    <?= $this->renderSection('main') ?>
                </main>

            </div>
        </div>

        <div id="alerts-wrapper" class="fixed inset-x-0 mx-auto bottom-5  max-w-xl sm:w-full space-y-5 z-50"></div>

        <?= $this->renderSection('modals') ?>

        <!-- BUY ME A BEER AND HELP SUPPORT OPEN-SOURCE RESOURCES -->
        <div class="flex items-end justify-end fixed bottom-0 right-0 mb-4 mr-4 z-10">
            <div>
                <a title="Buy me a beer" href="#" target="_blank"
                    class="block w-16 h-16 rounded-full transition-all shadow hover:shadow-lg transform hover:scale-110 hover:rotate-12">
                    <img class="object-cover object-center w-full h-full rounded-full"
                        src="https://i.pinimg.com/originals/60/fd/e8/60fde811b6be57094e0abc69d9c2622a.jpg" />
                </a>
            </div>
        </div>


        <?= $this->include('_notifications') ?>

        <?= $this->include('_modalsLogout') ?>


        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
        <script src="https://unpkg.com/hyperscript.org@0.9.7" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/datepicker.min.js"></script> -->
        <?= $this->renderSection('scriptsUrl') ?>

    </main>

    {CustomEvent}

    <?= $this->renderSection('scripts') ?>
    <?= $viewMeta->render('script') ?>
    <?= $viewMeta->render('rawScripts') ?>

</body>

</html>