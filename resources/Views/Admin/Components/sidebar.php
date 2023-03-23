<div class="flex md:flex-shrink-0" hx-boost="true" style="color-scheme: dark;">
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div x-show="open" class="relative z-40 lg:hidden" role="dialog" aria-modal="true" style="display: none;">
        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-on:click="open = false" class="fixed inset-0 bg-slate-600 bg-opacity-75" style="display: none;"></div>

        <div class="fixed inset-0 flex z-40">
            <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-on:click.away="open = false" class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4  dark:bg-slate-800 bg-white" style="display: none;">
                <div x-show="open" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute top-0 right-0 -mr-12 pt-2" style="display: none;">
                    <button x-on:click="open = false" type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg> </button>
                </div>

                <div class="flex-shrink-0 flex items-center px-4">
                    <a href="<?= site_url(); ?>" class="flex items-center">
                        <img src="https://demo.ticksify.com/img/logo-white-full.png" alt="Ticksify" class="h-8 w-auto">
                    </a>
                </div>
                <div class="mt-5 flex-1 h-0 overflow-y-auto">
                    <nav class="px-2 py-4">
                        <a href="<?= site_url(); ?>" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md bg-blue-100 text-blue-700 dark:bg-slate-900 text-white">
                            <svg aria-hidden="true" class="mr-4 flex-shrink-0 h-6 w-6 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"></path>
                            </svg> Dashboard
                        </a>
                        <a href="<?= site_url(); ?>/settings/general" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-slate-300 hover:bg-slate-700 hover:text-white">
                            <svg aria-hidden="true" class="mr-4 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg> Preferences
                        </a>
                        <?php
                        //  print_r($menu); exit; 
                        if (isset($menu)) : ?>
                            <?php foreach ($menu->collections() as $collection) : ?>

                                <div class="mt-10">
                                    <nav class="nav flex-column px-0">
                                        <?php if ($collection->isCollapsible()) : ?>
                                            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider"> <span><?= $collection->title ?></p>

                                            <div class="mt-2 space-y-1  <?= $collection->isActive() ? 'active' : 'flyout' ?>">
                                            <?php endif ?>


                                            <?php foreach ($collection->items() as $item) : ?>
                                                <?php if ($item->userCanSee()) : ?>
                                                    <a class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-slate-300 hover:bg-slate-700 hover:text-white <?= (in_array((string)$currentUrl, [$item->url])) ? "bg-blue-100 text-blue-700 dark:bg-slate-900" : ""; ?> <?= url_is($item->url . '*') ? 'active' : '' ?>" href="<?= $item->url ?>">
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
    <div class="hidden lg:flex w-64 flex-col">
        <div class="flex-1 flex flex-col min-h-0 border-r border-gray-200 dark:border-gray-800">
            <div class="flex h-16 flex-shrink-0 px-4 dark:bg-slate-800 bg-white">
                <a href="<?= site_url(ADMIN_AREA); ?>" class="flex items-center">
                    <img src="<?= base_url() . 'logo.png'; ?>" alt="Ticksify" class="h-10 w-auto dark:grayscale grayscale-0">
                </a>
            </div>
            <div class="flex-1 flex flex-col overflow-y-auto dark:bg-slate-800 bg-white">
                <nav class="flex-1 px-2 py-4 ">
                    <a href="<?= route_to('dashboard'); ?>" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:bg-gray-700 hover:text-gray-900 <?= (in_array((string)$currentUrl, [route_to('dashboard')])) ? "bg-blue-100 text-blue-700 dark:bg-slate-900" : ""; ?>">
                        <?= theme()->getSVG('duotune/graphs/gra008.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-gray-800 group-hover:text-slate-300', true); ?>
                        <?= lang('Btw.Dashboard'); ?>
                    </a>

                    <hr class="border-t border-gray-200 dark:border-gray-600 my-5" aria-hidden="true">

                    <?php
                    //  print_r($menu); exit; 
                    if (isset($menu)) : ?>
                        <?php foreach ($menu->collections() as $collection) : ?>

                            <div class="mt-10">
                                <nav class="nav flex-column px-0">
                                    <?php if ($collection->isCollapsible()) : ?>
                                        <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider"> <span><?= $collection->title ?></p>

                                        <div class="mt-2 space-y-1  <?= $collection->isActive() ? 'active' : 'flyout' ?>">
                                        <?php endif ?>


                                        <?php foreach ($collection->items() as $item) : ?>
                                            <?php if ($item->userCanSee()) : ?>
                                                <a class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 <?= (in_array((string)$currentUrl, [$item->url])) ? "bg-blue-100 text-blue-700 dark:bg-slate-900" : ""; ?> <?= url_is($item->url . '*') ? 'active' : '' ?>" href="<?= $item->url ?>">
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
            <div class="flex flex-shrink-0 dark:bg-slate-700 bg-gray-200 p-4">
                <a href="<?= route_to('user-current-settings') ?>" class="group block w-full flex-shrink-0">
                    <div class="flex items-center">
                        <div hx-get="<?= route_to('user-update-avatar'); ?>" hx-trigger="updateAvatar from:body" class="inline-block h-9 w-9 rounded-full">
                          <?= auth()->user()->renderAvatar(32, 'avatar w-8 h-8 rounded-full bg-gray-300 overflow-hidden') ?>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200"><?= Auth()->user()->last_name; ?> <?= Auth()->user()->first_name; ?></p>
                            <p class="text-xs font-medium text-gray-800 dark:text-gray-200 group-hover:text-gray-600">View profile</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>