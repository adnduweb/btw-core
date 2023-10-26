<div x-data="{ userActivity: false  }" x-show="userActivity" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div id="userActivity" x-show="userActivity" x-on:closemodal.window="userActivity = false" x-on:modaldelainotactivity.window="userActivity = true" class="fixed inset-0 z-50 overflow-y-auto px-5 my-5" aria-labelledby="modal-title" role="dialog" aria-modal="true" hx-target="this">
        <div id="dialog" x-show="userActivity" class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
            <!-- @click="userActivity = false"  -->
            <div x-cloak x-show="userActivity" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity backdrop-blur-sm bg-gray-500 bg-opacity-40" aria-hidden="true">
            </div>

            <div x-cloak x-show="userActivity" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full text-left transition-all transform bg-white dark:bg-gray-800  shadow-xl max-w-2xl my-20 rounded-lg" x-on:click.outside="$el.classList.add('animate-buzz'); setTimeout(() => $el.classList.remove('animate-buzz'), 500)" data-loading-states>
                <div class="flex items-center justify-between space-x-4  p-8 bg-gray-50 rounded-t-md">
                    <h1 class="text-xl font-medium text-gray-800 ">
                       Demande d'action
                    </h1>
                </div>

                <div hx-trigger="load">
                    <div class="p-8">
                <h2 class="text-3xl font-bold" :id="$id('modal-title')">Etes vous toujours la ? </h2>

                        <!-- Content -->
                        <p class="mt-2 text-gray-600">Votre session a expiré <span id="decompte"></span></p>

                        <!-- Buttons -->
                        <!-- <div class="mt-8 flex space-x-2">
                            <button type="button" x-on:click="$dispatch('setexpired');" class="rounded-md border border-gray-200 bg-white px-5 py-2.5">Ok
                            </button>
                        </div> -->
                       
</div>
<div class="px-4 py-3 text-right sm:px-6 bg-gray-100 rounded-b-md">
  
  <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.validate'), 'loading' => "loadingmodaladdcustomer"]) ?>

</div>
                </div>

            </div>
        </div>
    </div>
</div>