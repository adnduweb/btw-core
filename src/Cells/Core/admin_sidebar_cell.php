<div class="flex md:flex-shrink-0" hx-boost="true" style="color-scheme: light;">
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div x-show="open" class="relative z-40 lg:hidden" role="dialog" aria-modal="true" style="display: none;">
        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-on:click="open = false" class="fixed inset-0 bg-slate-600 bg-opacity-75" style="display: none;"></div>

        <div class="fixed inset-0 flex z-40">
            <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-on:click.away="open = false" class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4  dark:bg-slate-800 bg-gray-900" style="display: none;">
                <div x-show="open" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute top-0 right-0 -mr-12 pt-2" style="display: none;">
                    <button x-on:click="open = false" type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex-shrink-0 flex items-center px-4">
                    <a href="<?= site_url(); ?>" class="flex items-center">
                        <img src="<?= base_url() . 'admin/img/logo-adn-white.png'; ?>" alt="Ticksify" class=" w-full">
                    </a>
                </div>
                <div class="mt-5 flex-1 h-0 overflow-y-auto" x-data="{ expanded: false }">
                    <nav class="px-2 py-4">
                        <a href="<?= route_to('dashboard'); ?>" class="group flex items-center px-2 py-1 text-sm font-medium rounded-md text-gray-400 dark:text-slate-300 hover:bg-gray-800 dark:bg-gray-700 hover:text-white <?= (in_array((string)$currentUrl, [route_to('dashboard')])) ? "bg-gray-900 text-white dark:bg-slate-900" : ""; ?>">
                            <?= theme()->getSVG('duotune/graphs/gra008.svg', 'svg-icon group-hover:text-slate-300 flex-shrink-0 h-6 w-6 text-gray-800 group-hover:text-slate-300', true); ?>
                            <span><?= lang('Btw.Dashboard'); ?></span>
                        </a>

                        <hr class="border-t border-gray-200 dark:border-gray-600 my-5" aria-hidden="true">
                        <?php
                        //  print_r($menu); exit; 
                        if (isset($menu)) : ?>
                            <?php foreach ($menu->collections() as $collection) : ?>

                                <div class="mt-10">
                                    <nav class="nav flex-column px-0">
                                        <?php if ($collection->isCollapsible()) : ?>
                                            <p @click="expanded = ! expanded" class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider"> <span><?= $collection->title ?></p>

                                            <div x-show="expanded" x-collapse class="mt-2 space-y-1  <?= $collection->isActive() ? 'active' : 'flyout' ?>">
                                            <?php endif ?>


                                            <?php foreach ($collection->items() as $item) : ?>
                                                <?php if ($item->userCanSee()) : ?>
                                                    <a class="group flex items-center px-2 py-1 text-sm font-medium rounded-md text-gray-400 dark:text-slate-300 hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white <?= (in_array((string)$currentUrl, [$item->url])) ? "bg-gray-900 text-white dark:bg-slate-900" : ""; ?> <?= url_is($item->url . '*') ? 'active' : '' ?>" href="<?= $item->url ?>">
                                                        <?= $item->icon ?>
                                                        <span><?= $item->title ?></span>
                                                    </a>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            <?php if ($collection->isCollapsible()) : ?>
                                            </div>
                                        <?php endif ?>
                                    </nav>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                    </nav>
                </div>
            </div>

            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>
    <!-- Static sidebar for desktop -->
    <!-- x-on:mouseover="isSidebarExpanded = true" x-on:mouseleave="isSidebarExpanded = false" -->
    <div class="hidden lg:flex flex-col lg:inset-y-0 transition-all duration-300 ease-in-out" :class="isSidebarExpanded ? 'w-64' : 'w-20'">
        <div class="flex-1 flex flex-col min-h-0 border-r border-gray-200 dark:border-gray-800">
            <div class="flex items-center flex-shrink-0 px-4 dark:bg-slate-800 bg-gray-900" :class="isSidebarExpanded ? '' : 'pt-5 pb-5'">
                <a href="<?= site_url(ADMIN_AREA); ?>" class="flex items-center">
                    <img src="<?= base_url() . 'admin/img/logo-adn-white.png'; ?>" alt="ADN du Web" :class="isSidebarExpanded ? 'block' : 'hidden'" class="h-15 w-56 dark:grayscale grayscale-0 app-sidebar-logo-default">
                    <img x-cloak src="<?= base_url() . 'admin/img/logo-adn-small.png'; ?>" alt="ADN du Web" :class="isSidebarExpanded ? 'hidden' : 'block'" class="h-20px w-full dark:grayscale grayscale-0 app-sidebar-logo-minimize">
                </a>
            </div>
            <div class="flex-1 flex flex-col overflow-y-auto dark:bg-slate-800 bg-sidebar">
                <nav class="flex-1 px-2 py-4 items-center ">
                    <a x-data="tooltip" x-on:mouseover="show = true" x-on:mouseleave="show = false" :class="isSidebarExpanded ? '' : 'justify-center'" target="_blank" href="/" class="relative group flex items-center px-2 py-1 mb-5 text-sm font-medium rounded-md text-gray-400 dark:text-slate-300 hover:bg-gray-800 dark:bg-gray-700 hover:text-white">
                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z" fill="currentColor"></path>
                            <path d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z" fill="currentColor"></path>
                        </svg>
                        <span x-cloak x-bind:class="!isSidebarExpanded && show ? visibleClass :'' || !isSidebarExpanded && !show ? 'sm:hidden':''" :class="isSidebarExpanded ? 'block ml-3' : 'hidden'"><?= lang('Btw.displaySite'); ?></span>
                    </a>
                    <a x-data="tooltip" x-on:mouseover="show = true" x-on:mouseleave="show = false" :class="isSidebarExpanded ? '' : 'justify-center'" href="<?= route_to('dashboard'); ?>" class="relative group flex items-center px-2 py-1 text-sm font-medium rounded-md text-gray-400 dark:text-slate-300 hover:bg-gray-800 dark:bg-gray-700 hover:text-white <?= (in_array((string)$currentUrl, [route_to('dashboard')])) ? "bg-gray-900 text-white dark:bg-slate-900" : ""; ?>">
                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z" fill="currentColor"></path>
                            <path d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z" fill="currentColor"></path>
                        </svg>
                        <span x-cloak x-bind:class="!isSidebarExpanded && show ? visibleClass :'' || !isSidebarExpanded && !show ? 'sm:hidden':''" :class="isSidebarExpanded ? 'block ml-3' : 'hidden'"><?= lang('Btw.Dashboard'); ?></span>
                    </a>

                    <hr class="border-t border-gray-700 dark:border-gray-600 my-5" aria-hidden="true">

                    <?php
                    // print_r($menu); exit; 
                    if (isset($menu)) : ?>
                        <?php foreach ($menu->collections() as $collection) : ?>

                            <?php $allDisplay = false;
                            foreach ($collection->items() as $item) : ?>
                                <?php if ($item->userCanSee()) : ?>
                                    <?php $allDisplay = true; ?>
                                <?php endif ?>
                            <?php endforeach ?>

                            <?php if ($allDisplay == true) : ?>
                                <div :class="isSidebarExpanded ? 'mt-10' : 'mt-0'">
                                    <nav class="nav flex-column px-0">
                                        <?php if ($collection->isCollapsible()) : ?>
                                            <div class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider cursor-pointer " :class="isSidebarExpanded ? '' : 'sm:hidden'"> <span><?= $collection->title ?></span></div>

                                            <div class="mt-2 space-y-1  <?= $collection->isActive() ? 'active' : 'flyout' ?>">
                                            <?php endif ?>

                                            <?php foreach ($collection->items() as $item) : ?>
                                                <?php if ($item->userCanSee()) : ?>

                                                    <a x-data="tooltip" x-on:mouseover="show = true" x-on:mouseleave="show = false" data-current="<?= $currentUrl ?>" data-url="<?= $item->url; ?>" :class="isSidebarExpanded ? 'pl-5' : 'justify-center'" class="relative group flex items-center px-2 py-1 text-sm font-medium rounded-md text-gray-400 dark:text-slate-300 hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white <?= (in_array((string)$currentUrl, [$item->url])) ? "bg-gray-900 text-white dark:bg-slate-900" : ""; ?> <?= url_is($item->url . '*') ? 'active bg-gray-900 text-white dark:bg-slate-900' : '' ?>" href="<?= $item->url ?>">
                                                        <?= $item->icon ?>
                                                        <span x-cloak x-bind:class="!isSidebarExpanded && show ? visibleClass :'' || !isSidebarExpanded && !show ? 'sm:hidden':''" :class="isSidebarExpanded ? 'block ml-3' : 'hidden'"><?= $item->title ?></span>
                                                    </a>

                                                <?php endif ?>
                                            <?php endforeach ?>
                                            <?php if ($collection->isCollapsible()) : ?>
                                            </div>
                                        <?php endif ?>
                                    </nav>
                                </div>
                                <hr class="border-t border-gray-700 dark:border-gray-600 my-5" aria-hidden="true">
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </nav>
            </div>
            <div class="flex flex-shrink-0 dark:bg-slate-700 bg-gray-200 p-4">
                <a href="<?= route_to('user-profile-settings') ?>" class="group block w-full flex-shrink-0">
                    <div class="flex items-center">
                        <div hx-get="<?= route_to('user-update-avatar'); ?>" hx-trigger="updateAvatar from:body" class="inline-block rounded-full">
                            <?= auth()->user()->renderAvatar(50, 'avatar w-10 h-10 p-1 rounded-full ring-2 bg-gray-400 ring-gray-300 dark:ring-gray-500') ?>
                        </div>
                        <div class="ml-3" :class="isSidebarExpanded ? 'block' : 'hidden'">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200"><?= Auth()->user()->last_name; ?> <?= Auth()->user()->first_name; ?></p>
                            <p class="text-xs font-medium text-gray-800 dark:text-gray-200 group-hover:text-white"><?= lang('Btw.general.viewProfile'); ?></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>