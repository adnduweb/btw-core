<div :class="{ 'dark text-white-dark': $store.app.semidark }">
    <nav x-data="sidebar" class="sidebar fixed min-h-screen h-full top-0 bottom-0 w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] z-50 transition-all duration-300">
        <div class="bg-white dark:bg-[#0e1726] h-full">
            <div class="flex justify-between items-center px-4 py-3">
                <a href="/<?= ADMIN_AREA; ?>" class="main-logo flex items-center shrink-0">
                    <img class="w-8 ml-[5px] flex-none" src="<?php echo base_url('admin/images/logo.svg') ?>" alt="image" />
                    <span class="text-2xl ltr:ml-1.5 rtl:mr-1.5  font-semibold  align-middle lg:inline dark:text-white-light"><?= setting('Btw.titleNameAdmin'); ?></span>
                </a>
                <a href="javascript:;" class="collapse-icon w-8 h-8 rounded-full flex items-center hover:bg-gray-500/10 dark:hover:bg-dark-light/10 dark:text-white-light transition duration-300 rtl:rotate-180" @click='$store.app.toggleSidebar()' hx-get="<?= route_to('user-profile-sidebarexpanded'); ?>" hx-swap="none">
                    <svg class="w-5 h-5 m-auto" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
            <ul class="perfect-scrollbar relative font-semibold space-y-0.5 h-[calc(100vh-80px)] overflow-y-auto overflow-x-hidden  p-4 py-0" x-data="{ activeDropdown: null }">
                <li class="menu nav-item">
                    <a href="/<?= ADMIN_AREA; ?>" class="group">
                        <div class="flex items-center">

                            <svg class="group-hover:!text-primary shrink-0" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.5" d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z" fill="currentColor" />
                                <path d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z" fill="currentColor" />
                            </svg>
                            <span class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"><?= lang('Btw.Dashboard'); ?></span>
                        </div>
                    </a>
                </li>


                <?php
                // print_r($menu);
                // exit;
                if (isset($menu)) : ?>
                    <?php foreach ($menu->collections() as $collection) : ?>

                        <?php $allDisplay = false;
                        foreach ($collection->items() as $item) : ?>
                            <?php if ($item->userCanSee()) : ?>
                                <?php $allDisplay = true; ?>
                            <?php endif ?>
                        <?php endforeach ?>

                        <?php if ($allDisplay == true) : ?>
                            <?php if ($collection->isCollapsible()) : ?>
                                <h2 class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1">

                                    <svg class="w-4 h-5 flex-none hidden" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    <span><?= $collection->title ?></span>
                                </h2>

                                <li class="nav-item">
                                    <ul>
                                    <?php endif ?>

                                    <?php foreach ($collection->items() as $item) : ?>


                                        <?php if ($item->itemschild()) : ?>

                                            <li class="menu nav-item">
                                                <button type="button" class="nav-link group" :class="{ 'active': activeDropdown === '<?= strtolower($item->title) ?>' }" @click="activeDropdown === '<?= strtolower($item->title) ?>' ? activeDropdown = null : activeDropdown = '<?= strtolower($item->title) ?>'">
                                                    <div class="flex items-center">

                                                    <?= $item->icon ?>
                                                        <span class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"><?= $item->title ?></span>
                                                    </div>
                                                    <div class="rtl:rotate-180" :class="{ '!rotate-90': activeDropdown === '<?= strtolower($item->title) ?>' }">

                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </button>


                                                <ul x-cloak x-show="activeDropdown === '<?= strtolower($item->title) ?>'" x-collapse class="sub-menu text-gray-500">
                                                    <?php foreach ($item->itemschild() as $child) : ?>
                                                        <li>
                                                            <a  up-follow="" up-alias="<?= $child->url; ?>/*" data-current="<?= $currentUrl ?>" data-url="<?= $child->url; ?>" href="<?= $child->url ?>">
                                                                <?= $child->icon ?>
                                                                <span><?= $child->title ?></span>
                                                            </a>
                                                        </li>
                                                    <?php endforeach ?>
                                                </ul>
                                            </li>
                                        <?php else : ?>
                                            <?php if ($item->userCanSee()) : ?>
                                                <li class="nav-item">
                                                    <a up-follow="" up-alias="<?= $item->url; ?>/*" data-current="<?= $currentUrl ?>" data-url="<?= $item->url; ?>" class="group" href="<?= $item->url ?>">
                                                        <div class="flex items-center">
                                                            <?= $item->icon ?>
                                                            <span class="font-semibold ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"><?= $item->title ?></span>
                                                        </div>
                                                    </a>
                                                </li>

                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <?php if ($collection->isCollapsible()) : ?>
                                    </ul>
                                </li>

                            <?php endif ?>

                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>


                <h2 class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1">

                    <svg class="w-4 h-5 flex-none hidden" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>SUPPORTS</span>
                </h2>

                <li class="menu nav-item">
                    <a href="https://vristo.sbthemes.com" target="_blank" class="nav-link group">
                        <div class="flex items-center">

                            <svg class="group-hover:!text-primary shrink-0" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4 4.69434V18.6943C4 20.3512 5.34315 21.6943 7 21.6943H17C18.6569 21.6943 20 20.3512 20 18.6943V8.69434C20 7.03748 18.6569 5.69434 17 5.69434H5C4.44772 5.69434 4 5.24662 4 4.69434ZM7.25 11.6943C7.25 11.2801 7.58579 10.9443 8 10.9443H16C16.4142 10.9443 16.75 11.2801 16.75 11.6943C16.75 12.1085 16.4142 12.4443 16 12.4443H8C7.58579 12.4443 7.25 12.1085 7.25 11.6943ZM7.25 15.1943C7.25 14.7801 7.58579 14.4443 8 14.4443H13.5C13.9142 14.4443 14.25 14.7801 14.25 15.1943C14.25 15.6085 13.9142 15.9443 13.5 15.9443H8C7.58579 15.9443 7.25 15.6085 7.25 15.1943Z" fill="currentColor" />
                                <path opacity="0.5" d="M18 4.00038V5.86504C17.6872 5.75449 17.3506 5.69434 17 5.69434H5C4.44772 5.69434 4 5.24662 4 4.69434V4.62329C4 4.09027 4.39193 3.63837 4.91959 3.56299L15.7172 2.02048C16.922 1.84835 18 2.78328 18 4.00038Z" fill="currentColor" />
                            </svg>
                            <span class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Documentation</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("sidebar", () => ({
            init() {
                const selector = document.querySelector('.sidebar ul a[href="' + window.location
                    .pathname + '"]');
                if (selector) {
                    selector.classList.add('active');
                    const ul = selector.closest('ul.sub-menu');
                    if (ul) {
                        let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                        if (ele) {
                            ele = ele[0];
                            setTimeout(() => {
                                ele.click();
                            });
                        }
                    }
                }
            },
        }));
    });
</script>