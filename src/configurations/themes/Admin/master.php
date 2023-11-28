<!-- © ADN DU WEB CMS by adnduweb.com ® -->
<!doctype html>
<html dir="ltr" data-theme="retro" lang="<?= service('language')->getLocale(); ?>"
    class="h-full <?= detectBrowser(); ?>">

<head hx-preserve="true">
    <meta name="htmx-config"
        content='{"historyCacheSize": 0, "refreshOnHistoryMiss": false, "includeIndicatorStyles": false}'>
    <?= $viewMeta->render('meta') ?>
    <title>
        <?= $viewMeta->title() ?>
    </title>
    <?= csrf_meta() ?>
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <?= $viewJavascript->renderLangJson('admin/js/lang/' . service('request')->getLocale() . '.json');?>
    <?= asset_link('admin/js/perfect-scrollbar.min.js', 'js') ?>
    <?= asset_link('admin/js/popper.min.js', 'js', ['defer']) ?>
    <?= asset_link('admin/js/tippy-bundle.umd.min.js', 'js', ['defer']) ?>
    <?= asset_link('admin/js/sweetalert.min.js', 'js', ['defer']) ?>
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

<body x-data="main" hx-ext="alpine-morph, ajax-header, head-support, preload" hx-history="false"
    hx-indicator="#progress"
    class="antialiased relative font-nunito text-sm font-normal overflow-x-hidden collapsible-vertical full <?= detectAgent(); ?>"
    :class="[$store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ?  'dark' : '', $store.app.menu, $store.app.layout,$store.app.rtlClass]">

    <!-- sidebar menu overlay -->
    <div x-cloak class="fixed inset-0 bg-[black]/60 z-50 lg:hidden" :class="{ 'hidden': !$store.app.sidebar }"
        @click="$store.app.toggleSidebar()"></div>

    <div class="fixed bottom-6 ltr:right-6 rtl:left-6 z-50" x-data="scrollToTop">
        <template x-if="showTopButton">
            <button type="button"
                class="btn btn-outline-primary rounded-full p-2 animate-pulse bg-[#fafafa] dark:bg-[#060818] dark:hover:bg-primary"
                @click="goToTop">
                <svg width="24" height="24" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 20.75C12.4142 20.75 12.75 20.4142 12.75 20L12.75 10.75L11.25 10.75L11.25 20C11.25 20.4142 11.5858 20.75 12 20.75Z"
                        fill="currentColor" />
                    <path
                        d="M6.00002 10.75C5.69667 10.75 5.4232 10.5673 5.30711 10.287C5.19103 10.0068 5.25519 9.68417 5.46969 9.46967L11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5304 3.46967L18.5304 9.46967C18.7449 9.68417 18.809 10.0068 18.6929 10.287C18.5768 10.5673 18.3034 10.75 18 10.75L6.00002 10.75Z"
                        fill="currentColor" />
                </svg>
            </button>
        </template>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("scrollToTop", () => ({
                showTopButton: false,
                init() {
                    window.onscroll = () => {
                        this.scrollFunction();
                    };
                },

                scrollFunction() {
                    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                        this.showTopButton = true;
                    } else {
                        this.showTopButton = false;
                    }
                },

                goToTop() {
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop = 0;
                },
            }));
        });
    </script>

    <?= '' //$this->include('partials/theme-customiser')
?>

    <div class="main-container relative text-black dark:text-white-dark min-h-screen transition-fade <?= site_offline() ? 'offline' : '' ?>"
        :class="[$store.app.navbar]" x-data="{open: false}">

        <?= view_cell('Btw\Core\Cells\Core\AdminSidebar'); ?>

        <div class="main-content flex flex-col min-h-screen">
            <?= $this->include('partials/header') ?>

            <div id="progress" class="progress">
                <div class="indeterminate"></div>
            </div>

            <div class="p-6 animate__animated" :class="[$store.app.animation]">
                <?= $this->renderSection('main') ?>

            </div>

            <?= $this->include('partials/footer') ?>
        </div>
    </div>

    <div id="alerts-wrapper" class="fixed mx-auto top-5 right-5 max-w-lg sm:w-full space-y-5 z-50"></div>

    <?= $this->renderSection('modals') ?>
    <?= $this->include('partials/modal-session-expired') ?>
    <?= $this->include('partials/modal-delete') ?>
    <?= $this->include('partials/modal-auth-display-data') ?>
    <?= $this->include('_notifications') ?>
    <?= view_cell('Btw\Core\Cells\Core\AdminSideOver'); ?>

    <?= $viewJavascript->render(); ?>
    <?= asset_link('admin/js/moment.min.js', 'js') ?>
    <?= asset_link('admin/js/moment-with-locales.min.js', 'js') ?>
    <?= asset_link('admin/js/_hyperscript.min.js', 'js') ?>
    <?= asset_link('admin/js/zxcvbn.js', 'js') ?>
    <?= $this->renderSection('scriptsUrl') ?>

    {CustomEvent}

    <?= $this->renderSection('scripts') ?>
    <?= $viewMeta->render('script') ?>
    <?= $viewMeta->render('rawScripts') ?>

    <?php if (setting('Btw.activeWebsocket') == true): ?>

        <script>

            var conn = new WebSocket('ws://localhost:8282/stream');
            var client = {
                user_id: <?= Auth()->user()->id; ?>,
                recipient_id: null,
                type: 'socket',
                token: null,
                message: null
            };
            conn.onopen = function (e) {
                console.log("Connection established!");
            };

            conn.onmessage = function (e) {
                var data = JSON.parse(e.data);
                if (data.message) {
                    $('#messages').append(data.user_id + ' : ' + data.message + '<br>');
                }
                if (data.type === 'token') {
                    $('#token').html('JWT Token : ' + data.token);
                }

            };

            client.message = 'Bonjour';
            // client.token = "sfgsdgfdsgsfdgdfsg";
            client.type = 'chat';

            conn.onopen = () => conn.send(JSON.stringify(client));
            // conn.onopen = () => conn.send('hello jourbon');

        </script>
    <?php endif; ?>

</body>

</html>