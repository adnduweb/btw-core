<div class="mb-4 flex flex-col md:flex-row justify-between items-center">
    <!--begin::Card title-->
    <div class="flex-1 w-full md:pr-4 pb-5 md:pb-0">
        <!--begin::Search-->
        <div class="relative md:w-1/3">
            <input type="search" data-kt-datatable-filter="search" class="w-full pl-10 pr-4 py-2 border-gray-300 dark:border-transparent rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-400 dark:bg-gray-700 font-medium" placeholder="<?= lang('Btw.search'); ?>" aria-label="Search" aria-describedby="button-addon1" value="<?= service('session')->get('dt_' . $_controller)['search'] ?? ''; ?>" />
            <div class="absolute top-0 left-0 inline-flex items-center p-2">
                <?= service('theme')->getSVG('duotone/General/Search.svg', "svg-icon svg-icon-1 position-absolute ms-2"); ?>
            </div>
        </div>
        <!--end::Search-->
    </div>
    <!--begin::Card title-->

    <div class="card-toolbar-only">

        <!--begin::Toolbar-->
        <div class="flex flex-row-reverse" data-kt-datatable-toolbar="only" hx-boost="true">

            <?php if (!empty($settings)) : ?>
                <a href="<?= $settings['href']; ?>" class="ml-2 rounded-lg inline-flex items-center bg-white hover:text-blue-500 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4 shadow rounded-lg flex">
                <?= service('theme')->getSVG('admin/images/icons/cod001.svg', 'svg-icon flex-shrink-0 dark:text-gray-200 text-gray-800', true); ?>
                </a>
            <?php endif; ?>

            <?php if (!empty($add)) : ?>
                <a href="<?= $add['href']; ?>" <?php if (!empty($add['htmxFormat'])) : ?> <?=  $add['htmxFormat']; ?> <?php endif; ?> class="ml-2 inline-flex justify-center cursor-pointer bg-blue-500 text-white active:bg-blue-600 dark:bg-gray-800 font-bold px-4 py-2 text-sm rounded-md shadow hover:shadow-md outline-none focus:outline-none mr-1 ">
                    <?= $add['titre']; ?>
                </a>
            <?php endif; ?>

            <?php if ($filter == true) : ?>
                <div class="shadow rounded-lg flex">
                    <button type="button" class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4" x-on:click="open = !open" aria-haspopup="true" x-bind:aria-expanded="open" aria-expanded="false">
                        <?= lang('Btw.general.filters'); ?>

                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>


            <?php if (!empty($import)) : ?>
                <a target="_blank" href="<?= $import['href']; ?>" class="mr-2 rounded-lg inline-flex items-center bg-white hover:text-blue-500 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4 shadow rounded-lg flex">
                    <?= theme()->getSVG('admin/images/icons/arr078.svg', 'svg-icon flex-shrink-0 dark:text-gray-200 text-gray-800', true); ?>
                </a>
            <?php endif; ?>

            <?php if (!empty($export)) : ?>


                <?php if (isset($export['type'])) : ?>

                    <!-- Profile dropdown -->
                    <div class="ml-3 relative" hx-boost="true">
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                            <div @click="open = ! open" class="">
                                <button type="button" class="mr-2 rounded-lg inline-flex items-center bg-white hover:text-blue-500 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4 shadow rounded-lg flex" aria-expanded="false" aria-haspopup="true">
                                    <?= theme()->getSVG('admin/images/icons/arr091.svg', 'svg-icon flex-shrink-0 dark:text-gray-200 text-gray-800', true); ?>
                                </button>
                            </div>

                            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 my-2 w-56 rounded-md shadow-lg origin-top-right right-0 top-full" style="display: none;" @click="open = false">
                                <div class="rounded-md ring-1 ring-black ring-opacity-5 dark:ring-slate-600 py-1 bg-white dark:bg-slate-800">
                                    <?php foreach ($export['type'] as $type) : ?>
                                        <a target="_blank" class="block px-4 py-2 text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-700 dark:hover:bg-slate-700" href="<?= $export['href']; ?>?type=<?= $type; ?>"><?= lang(ucfirst($_controller) . '.export.' . $type); ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <a target="_blank" href="<?= $export['href']; ?>" class="mr-2 rounded-lg inline-flex items-center bg-white hover:text-blue-500 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4 shadow rounded-lg flex">
                        <?= theme()->getSVG('admin/images/icons/arr091.svg', 'svg-icon flex-shrink-0 dark:text-gray-200 text-gray-800', true); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

        </div>
        <!--end::Toolbar-->
    </div>



    <!--begin::Card toolbar-->
    <div class="card-toolbar">

        <!--begin::Toolbar-->
        <div class="d-flex justify-content-end" data-kt-datatable-toolbar="base">

        </div>
        <!--end::Toolbar-->

        <?php if (isset($actions)) : ?>
            <!--begin::Group actions-->
            <div class="d-flex justify-content-end align-items-center hidden  ml-2" data-kt-datatable-toolbar="selected">
                <div class="fw-bolder me-5">
                </div>
                <div class="shadow rounded-lg flex" x-data="{ open: false }">
                    <div class="relative">
                        <button @click.prevent="open = !open" class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <path d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5">
                                </path>
                            </svg>
                            <span class="hidden md:block">
                                <?= lang('Btw.Action'); ?>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="z-40 absolute top-0 right-0 w-40 bg-white dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden" style="display: none;">

                            <?php foreach ($actions as $action) : ?>
                                <?php
                                switch ($action) {
                                    case 'delete':
                                        ?>
                                        <div class="flex flex-col justify-between items-center text-truncate hover:bg-gray-100 dark:hover:bg-gray-600 px-4 py-2">
                                            <button type="button" class="w-full flex justify-start text-red-700 dark:text-gray-200" data-kt-datatable-action="delete_selected">
                                                <span>
                                                    <?= lang('Btw.general.delete'); ?>
                                                </span>
                                            </button>
                                        </div>
                                    <?php
                                                break;
                                    case 'activate':
                                        ?>
                                        <div class="flex flex-col justify-between items-center text-truncate hover:bg-gray-100 px-4 py-2">
                                            <button type="button" class="w-full flex justify-start" data-kt-datatable-action="active_selected">
                                                <span>
                                                    <?= lang('Btw.general.active'); ?>
                                                </span>
                                            </button>
                                        </div>
                                    <?php
                                            break;
                                    case 'desactivate':
                                        ?>
                                        <div class="flex flex-col justify-between items-center text-truncate hover:bg-gray-100 px-4 py-2">

                                            <button type="button" class="w-full flex justify-start" data-kt-datatable-action="descative_selected">
                                                <span>
                                                    <?= lang('Btw.general.desactive'); ?>
                                                </span>
                                            </button>
                                        </div>
                                    <?php
                                            break;

                                    default:
                                        ?>
                                        <div class="flex flex-col justify-between items-center text-truncate hover:bg-gray-100 px-4 py-2">

                                            <button type="button" class="w-full flex justify-start" data-kt-datatable-action-custom="<?= $action; ?>">
                                                <span>
                                                    <?= lang(nameController() . '.actions.' . $action); ?>
                                                </span>
                                            </button>
                                        </div>
                                <?php
                                }
                                ?>

                            <?php endforeach ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
    <!--end::Group actions-->

</div>
<!--end::Card toolbar-->

<?php if (!empty($filter)) : ?>
    <?= view_cell('Btw\Core\Cells\Datatable\DatatableDFilter', ['fieldsFilter' => $fieldsFilter]); ?>
<?php endif; ?>