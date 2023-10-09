<div x-data="{ <?= $params['type']; ?>: false  }" x-show="<?= $params['type']; ?>" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div id="<?= $params['type']; ?>" x-show="<?= $params['type']; ?>" x-on:closemodal.window="<?= $params['type']; ?> = false" x-on:openmodal<?= $params['name']; ?>.window="<?= $params['type']; ?> = true" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" hx-target="this">
        <div id="dialog" x-show="<?= $params['type']; ?>" class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
            <!-- @click="<?= $params['type']; ?> = false"  -->
            <div x-cloak x-show="<?= $params['type']; ?>" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity backdrop-blur-sm bg-gray-500 bg-opacity-40" aria-hidden="true">
            </div>

            <div x-cloak x-show="<?= $params['type']; ?>" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full text-left transition-all transform bg-white dark:bg-gray-800  shadow-xl <?= isset($params['containerFull']) ? 'w-full h-full'  : 'max-w-2xl my-20 rounded-lg'; ?>" x-on:click.outside="$el.classList.add('animate-buzz'); setTimeout(() => $el.classList.remove('animate-buzz'), 500)" data-loading-states>
                <div class="flex items-center justify-between space-x-4  p-8 bg-gray-50 rounded-t-md">
                    <h1 class="text-xl font-medium text-gray-800 ">
                        <?= $params['title']; ?>
                    </h1>

                    <button @click="<?= $params['type']; ?> = false" class="text-gray-600 dark:text-gray-300 focus:outline-none hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>

                <div id="<?= $params['identifier']; ?>" class="<?= $params['identifier']; ?>" hx-trigger="load">
                </div>

            </div>
        </div>
    </div>
</div>