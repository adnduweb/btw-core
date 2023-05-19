<div id="notificationswrapper">
    <div x-data="{
        notifications: [],
        add(e) {
            this.notifications.push({
                id: e.timeStamp,
                type: e.detail.type,
                content: e.detail.content,
            })
        },
        remove(notification) {
            this.notifications = this.notifications.filter(i => i.id !== notification.id)
        },
    }" @notify.window="add($event)" class="fixed top-0 z-10 right-0 flex w-full max-w-lg flex-col space-y-4 pr-4 pb-4 sm:justify-start" role="status" aria-live="polite">
        <!-- Notification -->
        <template x-for="notification in notifications" :key="notification.id">
            <div x-data="{
                show: false,
                init() {
                    this.$nextTick(() => this.show = true)
 
                    setTimeout(() => this.transitionOut(), 2000)
                },
                transitionOut() {
                    this.show = false
 
                    setTimeout(() => this.remove(this.notification), 500)
                },
            }" x-show="show" x-transition.duration.500ms class="pointer-events-auto relative w-full max-w-lg rounded-md border border-gray-200 dark:bg-white bg-gray-800 py-4 pl-6 pr-4 shadow-lg">
                <div class="flex items-center">
                    <!-- Icons -->
                    <div x-show="notification.type === 'info'" class="flex-shrink-0">
                        <span aria-hidden="true" class="inline-flex h-6 w-6 items-center justify-center rounded-full border-2 dark:border-gray-400 border-gray-100 text-xl font-bold dark:text-gray-400 text-gray-100">!</span>
                        <span class="sr-only">Information:</span>
                    </div>

                    <div x-show="notification.type === 'success'" class="flex-shrink-0">
                        <span aria-hidden="true" class="inline-flex h-6 w-6 items-center justify-center rounded-full border-2 border-green-600 text-lg font-bold text-green-600">&check;</span>
                        <span class="sr-only">Success:</span>
                    </div>

                    <div x-show="notification.type === 'error'" class="flex-shrink-0">
                        <span aria-hidden="true" class="inline-flex h-6 w-6 items-center justify-center rounded-full border-2 border-red-600 text-lg font-bold text-red-600">&times;</span>
                        <span class="sr-only">Error:</span>
                    </div>

                    <!-- Text -->
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p x-html="notification.content" class="text-sm font-medium leading-5 dark:text-gray-900 text-gray-200"></p>
                    </div>

                    <!-- Remove button -->
                    <div class="ml-4 flex flex-shrink-0">
                        <button @click="transitionOut()" type="button" class="inline-flex text-gray-400">
                            <svg aria-hidden class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close notification</span>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

</div>