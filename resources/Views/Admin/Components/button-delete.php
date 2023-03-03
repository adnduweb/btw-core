<div x-data="{ initial: true, deleting: false }" class="text-sm flex items-center relative shadow w-[2rem]">
    <button
        x-on:click.prevent="deleting = true; initial = false"
        x-show="initial"
        x-on:deleting.window="$el.disabled = true"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        class="text-white p-1 rounded bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 disabled:opacity-50 "
    >
        <?= theme()->getSVG('duotune/general/gen027.svg', 'svg-icon svg-white fill-white', true); ?>
    </button>

    <div
        x-show="deleting"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="flex flex-col justify-center items-center px-3 absolute left-[-5.6rem] shadow bg-gray-800 rounded z-10"
    >
        <span class="text-gray-200 dark:text-gray-800 py-2"> <?= ucfirst(lang('Btw.AreYouSure?')); ?></span>

        <form hx-delete="<?= $route_to; ?>" method="delete" action="<?= $route_to; ?>" class="py-2">
            <?= ''; // csrf_field() ?>

            <button
                x-on:click="$el.form.submit()"
                x-on:deleting.window="$el.disabled = true"
                type="submit"
                class="text-white p-1 rounded bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 disabled:opacity-50"
            >
                <?= ucfirst(lang('Btw.yes')); ?>
            </button>

            <button
                x-on:click.prevent="deleting = false; setTimeout(() => { initial = true }, 150)"
                x-on:deleting.window="$el.disabled = true"
                class="text-white p-1 rounded bg-gray-600 hover:bg-gray-700 dark:bg-gray-500 dark:hover:bg-gray-600 disabled:opacity-50"
            >
            <?= ucfirst(lang('Btw.no')); ?>
            </button>
        </form>
    </div>
</div>