<div
x-on:authdisplaydatamodalcomponent.window="
showAuthDisplayDataModal = $event.detail.showAuthDisplayDataModal; 
title = $event.detail.title; 
message = $event.detail.message
id = $event.detail.id
module = $event.detail.module
identifier = $event.detail.identifier
actionHtmx = $event.detail.actionHtmx
route = $event.detail.route" 
x-init="$watch('showAuthDisplayDataModal', value => {
        if (showAuthDisplayDataModal) {
            htmx.process(document.querySelector('#modalAuthDisplayDataCompoment'))
        }
    })" x-transition> 
    <template x-if="showAuthDisplayDataModal">
        <div id="showAuthDisplayDataModal" x-show="showAuthDisplayDataModal" x-on:closemodal.window="showAuthDisplayDataModal = false" class="fixed inset-0 z-[9999999999] overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
                <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">

                    <div x-cloak x-show="showAuthDisplayDataModal"
                        x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 transition-opacity backdrop-blur-sm bg-gray-500 bg-opacity-40" aria-hidden="true">
                    </div>
                
                        <div x-cloak x-show="showAuthDisplayDataModal" x-transition:enter="transition ease-out duration-300 transform"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="transition ease-in duration-200 transform"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            class="inline-block w-full max-w-xl my-20 text-left transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl 2xl:max-w-2xl"
                            x-on:click.outside="$el.classList.add('animate-buzz'); setTimeout(() => $el.classList.remove('animate-buzz'), 500)" 
                            data-loading-states>
                            <div class="flex items-center justify-between space-x-4 p-4 bg-gray-50 rounded-t-md">
                                <h1 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    <span x-text="title"></span>
                                </h1>

                                <button @click="showAuthDisplayDataModal = false"
                                    class="text-gray-600 dark:text-gray-300 focus:outline-none hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                            <form id="modalAuthDisplayDataCompoment" :hx-post="route" method="post" :action="route" hx-ext="loading-states, event-header" class="">
                                <?= csrf_field() ; ?>
                                <div class="p-8 mt-4 text-sm text-gray-600 dark:text-gray-400"  x-data="{ show: true }">
                                    <p  x-text="message"></p>

                                    <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                                        'type' => 'password',
                                        'label' => null,
                                        'name' => 'password',
                                        'value' => old('password', null),
                                        'xType' => "show ? 'password' : 'text'",
                                        'lang' => false
                                    ]); ?>

                                </div>

                                <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 dark:bg-gray-800 text-right rounded-b-md">
                                    <input type="hidden" name="section" value="verif" />
                                    <input type="hidden" name="module" :value="module" />
                                    <input type="hidden" name="identifier" :value="identifier" />
                                    <input type="hidden" name="actionHtmx" :value="actionHtmx" />
                                
                                    <button type="button"
                                        class="inline-flex justify-center cursor-pointer bg-gray-500 text-white active:bg-gray-600 dark:bg-gray-900 font-bold px-4 py-2 text-sm rounded-md shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-in-out duration-1200 transition-all"
                                        @click="showAuthDisplayDataModal = false">
                                        <?= lang('Btw.close'); ?>
                                    </button>
                                    <button type="submit" :data-id="id" class="inline-flex justify-center cursor-pointer bg-blue-500 text-white active:bg-blue-600 dark:bg-gray-900  font-bold px-4 py-2 text-sm rounded-md shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-in-out duration-1200 transition-all"><?= lang('Btw.sendData'); ?></button>
                                </div>
                            </form>
                        </div>
                    
                </div>
        </div>
    </template>
</div>