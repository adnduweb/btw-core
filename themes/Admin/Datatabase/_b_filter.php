<div class="shadow rounded-lg flex">
    <button type="button"
        class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4"
        x-on:click="open = !open" aria-haspopup="true" x-bind:aria-expanded="open" aria-expanded="false">
        <?= lang('Btw.general.filters'); ?>

        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
            </path>
        </svg>
    </button>
</div>
