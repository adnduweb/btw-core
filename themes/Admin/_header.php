<div class="relative z-10 flex h-16 flex-shrink-0 bg-white shadow border-slate-200 dark:border-slate-600 dark:bg-slate-800">
    <button @click="open = !open" type="button" class="px-4 border-r border-slate-200 text-slate-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-slate-900 lg:hidden dark:border-slate-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"></path>
        </svg>
    </button>
    <header class="flex items-center px-6 hidden lg:flex">
        <button class="p-2 -ml-2 mr-2" @click="isSidebarExpanded = !isSidebarExpanded" hx-get="<?= route_to('user-profile-sidebarexpanded'); ?>" hx-swap="none">
            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 transform" :class="isSidebarExpanded ? 'rotate-180' : 'rotate-0'">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="4" y1="6" x2="14" y2="6"></line>
                <line x1="4" y1="18" x2="14" y2="18"></line>
                <path d="M4 12h17l-3 -3m0 6l3 -3"></path>
            </svg>
        </button>
    </header>
    <div class="flex-1 px-4 flex justify-between">
        <div class="flex-1 flex">
            <form class="w-full flex md:ml-0" action="#" method="GET">
                <label for="search-field" class="sr-only">
                    <?= lang('Btw.general.search'); ?>
                </label>
                <div class="relative w-full text-slate-400 focus-within:text-slate-600 dark:focus-within:text-slate-300">
                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input id="search-field" type="search" name="search" class="block w-full h-full pl-8 pr-3 py-2 border-transparent bg-transparent text-slate-900 placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-0 focus:border-transparent sm:text-sm dark:text-slate-100 dark:placeholder-slate-400 dark:focus:placeholder-slate-500" placeholder="<?= lang('Form.general.search'); ?>" kl_vkbd_parsed="true">
                </div>
            </form>
        </div>
        <div class="ml-4 flex items-center md:ml-6">
            <!-- Notification -->
            <a wire:id="YJGIKTtJWEEA3jMOUSny" wire:poll.30000ms="" href="https://demo.ticksify.com/agent/notifications" class="relative bg-white p-1 rounded-full text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-slate-800 dark:text-slate-300 dark:hover:text-slate-200 dark:focus:ring-offset-slate-800" title="You have no new notifications">
                <span class="sr-only">Open notification page</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
                </svg> </a>
            <!-- Livewire Component wire-end:YJGIKTtJWEEA3jMOUSny -->
            <!-- Open ticket dropdown -->
            <div wire:id="1mN9D311seLziaeEf0XO">
                <div class="ml-3 relative">
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                        <div @click="open = ! open" class="">
                            <button type="button" class="relative bg-white p-1 rounded-full text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-slate-800 dark:text-slate-300 dark:hover:text-slate-200 dark:focus:ring-offset-slate-800">
                                <span class="sr-only">Open notification page</span>
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.875 14.25l1.214 1.942a2.25 2.25 0 001.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 011.872 1.002l.164.246a2.25 2.25 0 001.872 1.002h2.092a2.25 2.25 0 001.872-1.002l.164-.246A2.25 2.25 0 0116.954 9h4.636M2.41 9a2.25 2.25 0 00-.16.832V12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 01.382-.632l3.285-3.832a2.25 2.25 0 011.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0021.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 002.25 2.25z"></path>
                                </svg> <span class="absolute block top-0.5 right-0 h-2.5 w-2.5 rounded-full bg-blue-400 ring-2 ring-white dark:ring-slate-800"></span>
                            </button>
                        </div>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 my-2 w-80 rounded-md shadow-lg origin-top-right right-0 top-full" style="display: none;" @click="open = false">
                            <div class="rounded-md ring-1 ring-black ring-opacity-5 dark:ring-slate-600 py-1 bg-white dark:bg-slate-800">
                                <div class="px-4 py-2 border-b border-slate-200 font-medium text-xs text-slate-700 dark:border-slate-600 dark:text-slate-200">
                                    Ticket waiting for your response
                                </div>
                                <div x-init="$watch('open', function(value) {
                        if (value) {
                            $wire.loadOpenTickets();
                        }
                    })" class="max-h-96 overflow-y-auto">
                                    <div wire:target="loadOpenTickets" wire:loading.block="" class="p-4">
                                        <div class="animate-pulse flex space-x-4">
                                            <div class="flex-1 space-y-6 py-1">
                                                <div class="space-y-3">
                                                    <div class="grid grid-cols-3 gap-4">
                                                        <div class="h-2 bg-slate-700 rounded col-span-2"></div>
                                                        <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                                                    </div>
                                                    <div class="h-2 bg-slate-700 rounded"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:target="loadOpenTickets" wire:loading.remove="" class="divide-y divide-slate-200 dark:divide-slate-600">
                                        <div class="px-4 py-3">
                                            <p class="text-slate-900 text-sm dark:text-slate-200">
                                                Nope, you have no open tickets.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Livewire Component wire-end:1mN9D311seLziaeEf0XO -->
            <!-- Theme switcher -->
            <div class="ml-3 relative">
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <div @click="open = ! open" class="">
                        <button type="button" class="p-1 text-slate-400 rounded-full hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:text-slate-300 dark:hover:text-slate-200 dark:focus:ring-offset-slate-800">
                            <template x-if="theme === 'light'">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"></path>
                                </svg>
                            </template>
                            <template x-if="theme === 'dark'">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"></path>
                                </svg>
                            </template>
                            <template x-if="theme === 'system'">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"></path>
                                </svg>
                            </template>
                        </button>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 my-2 w-48 rounded-md shadow-lg origin-top-right right-0 top-full" style="display: none;" @click="open = false">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 dark:ring-slate-600 py-1 bg-white dark:bg-slate-800">
                            <a class="block px-4 py-2 text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-700 dark:hover:bg-slate-700 flex items-center space-x-2" x-on:click="theme = 'light'" role="button"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM10 15a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 15zM10 7a3 3 0 100 6 3 3 0 000-6zM15.657 5.404a.75.75 0 10-1.06-1.06l-1.061 1.06a.75.75 0 001.06 1.06l1.06-1.06zM6.464 14.596a.75.75 0 10-1.06-1.06l-1.06 1.06a.75.75 0 001.06 1.06l1.06-1.06zM18 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 0118 10zM5 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 015 10zM14.596 15.657a.75.75 0 001.06-1.06l-1.06-1.061a.75.75 0 10-1.06 1.06l1.06 1.06zM5.404 6.464a.75.75 0 001.06-1.06l-1.06-1.06a.75.75 0 10-1.061 1.06l1.06 1.06z"></path>
                                </svg> <span>Light</span></a>
                            <a class="block px-4 py-2 text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-700 dark:hover:bg-slate-700 flex items-center space-x-2" x-on:click="theme = 'dark'" role="button"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.455 2.004a.75.75 0 01.26.77 7 7 0 009.958 7.967.75.75 0 011.067.853A8.5 8.5 0 116.647 1.921a.75.75 0 01.808.083z" clip-rule="evenodd"></path>
                                </svg> <span>Dark</span></a>
                            <a class="block px-4 py-2 text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-700 dark:hover:bg-slate-700 flex items-center space-x-2" x-on:click="theme = 'system'" role="button"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M2 4.25A2.25 2.25 0 014.25 2h11.5A2.25 2.25 0 0118 4.25v8.5A2.25 2.25 0 0115.75 15h-3.105a3.501 3.501 0 001.1 1.677A.75.75 0 0113.26 18H6.74a.75.75 0 01-.484-1.323A3.501 3.501 0 007.355 15H4.25A2.25 2.25 0 012 12.75v-8.5zm1.5 0a.75.75 0 01.75-.75h11.5a.75.75 0 01.75.75v7.5a.75.75 0 01-.75.75H4.25a.75.75 0 01-.75-.75v-7.5z" clip-rule="evenodd"></path>
                                </svg> <span>System</span></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile dropdown -->
            <div class="ml-3 relative"  hx-boost="true">
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <div @click="open = ! open" class="">
                        <button type="button" class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-slate-800" aria-expanded="false" aria-haspopup="true">
                            <span class="avatar w-8 h-8 rounded-full bg-gray-300 overflow-hidden">
                                <?= theme()->getSVG(Config('Btw')->supportedLocales[service('language')->getLocale()]['flag'], 'svg-icon mr-3 w-5 h-5 flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800'); ?>
                            </span>
                        </button>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 my-2 w-48 rounded-md shadow-lg origin-top-right right-0 top-full" style="display: none;" @click="open = false">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 dark:ring-slate-600 py-1 bg-white dark:bg-slate-800">
                            <?php foreach (Config('Btw')->supportedLocales as $key => $lang) { ?>
                                <a class="block px-4 py-2 text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-700 dark:hover:bg-slate-700 flex" 
                                href="<?= route_to('user-profile-language') ?>?changeLanguageBO=<?= $lang['iso_code']; ?>">
                                    <?= theme()->getSVG($lang['flag'], 'flex svg-icon mr-3 w-5 h-5 flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800'); ?>
                                    <span class="ml-5"><?= lang($lang['name']); ?></span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile dropdown -->
            <div class="ml-3 relative" hx-boost="true">
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <div @click="open = ! open" class="">
                        <button hx-get="<?= route_to('user-update-avatar'); ?>" hx-trigger="updateAvatar from:body" type="button" class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-slate-800" aria-expanded="false" aria-haspopup="true">
                            <?= $this->setVar('auth', auth())->include('partials/headers/renderAvatar'); ?>
                        </button>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 my-2 w-48 rounded-md shadow-lg origin-top-right right-0 top-full" style="display: none;" @click="open = false">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 dark:ring-slate-600 py-1 bg-white dark:bg-slate-800">
                            <a class="block px-4 py-2 text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-700 dark:hover:bg-slate-700" href="<?= route_to('user-profile-settings') ?>"><?= lang('Btw.general.accountProfile'); ?></a>
                            <a class="block px-4 py-2 text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-700 dark:hover:bg-slate-700" href="<?= route_to('logout') ?>"><?= lang('Btw.general.signOut'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>