<div x-data="{ open: false }" class="flex justify-center">
    <!-- Trigger -->
    <span x-on:click="open = true">
        <button type="button" class="text-white p-1 rounded text-red-600 hover:text-red-700 dark:text-gray-200 dark:hover:text-gray-800 disabled:opacity-50">
            <?= theme()->getSVG('duotune/general/gen027.svg', 'svg-icon text-gray-800 dark:text-gray-200 hover:text-red-600 dark:hover:text-red-600'); ?>
        </button>
    </span>

    <!-- Modal -->
    <div x-show="open" style="display: none" x-on:keydown.escape.prevent.stop="open = false" role="dialog" aria-modal="true" x-id="['modal-title']" :aria-labelledby="$id('modal-title')" class="fixed inset-0 z-10 overflow-y-auto">
        <!-- Overlay -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

        <!-- Panel -->
        <div x-show="open" x-transition x-on:click="open = false" class="relative flex min-h-screen items-center justify-center p-4">
            <div x-on:click.stop x-trap.noscroll.inert="open" class="relative w-full max-w-2xl overflow-y-auto rounded-lg bg-white shadow-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg">
                                Please confirm your action!
                            </h3>

                            <div class="mt-2">
                                Are you sure you want to learn how to create an awesome modal?
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-row justify-end px-6 py-3 bg-gray-100 text-right">
                    <div>
                        <button x-on:click="open = false" class="inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-blue-100 text-blue-700 hover:bg-blue-200 focus:border-blue-300 focus:ring-blue-200 active:bg-blue-300" type="button" wire:click="$set('showDeleteModal', false)">
                            Cancel
                        </button>
                        <button hx-delete="<?= route_to('group-delete', $group['alias']); ?>" hx-target="#row_group_<?= $group['alias'] ?>" hx-swap="none" class="inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-red-600 text-white hover:bg-red-500 focus:border-red-700 focus:ring-red-200 active:bg-red-600" type="submit">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>