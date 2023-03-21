<div x-data="noticesHandler" @notice.window="add($event.detail)">
    <div class="fixed inset-x-0 mx-auto bottom-5 overflow-hidden max-w-xl sm:w-full space-y-5 z-50">
        <template x-for="notice of notices" :key="notice.id">
            <div x-show="visible.includes(notice)" x-transition:enter="transition ease-in duration-200" x-transition:enter-start="transform opacity-0 translate-y-2" x-transition:enter-end="transform opacity-100" x-transition:leave="transition ease-out duration-500" x-transition:leave-start="transform  opacity-100" x-transition:leave-end="transform  opacity-0" @click="remove(notice.id)" class="bg-gray-900 bg-gradient-to-r dark:bg-gray-600 text-white p-3 rounded mb-3 shadow-lg flex justify-between items-center" :class="{
                    'bg-blue-500 to-blue-600': notice.type === 'info',
                    'from-green-500 to-green-600 dark:from-gray-600 dark:to-gray-600 ': notice.type === 'success',
                    'bg-yellow-400 to-yellow-500': notice.type === 'warning',
                    'from-red-500 to-pink-500': notice.type === 'error',
                }" style="pointer-events:all">

                <div class="col-start-1 col-span-3">
                    <div class="text-white text-right">
                        <span x-html="notice.text"></span>
                    </div>
                </div>
                <div class="col-start-4 col-span-1" x-html="getIcon(notice)"></div>
            </div>
        </template>
    </div>
</div>