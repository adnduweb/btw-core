<div x-cloak x-show="open" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95">
    <div class="flex">

        <div class="w-full shadow p-5 mb-5 rounded-lg bg-white">

            <div class="flex items-center justify-between mt-4">
                <p class="font-medium">
                    Filters
                </p>

                <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md"
                    data-kt-datatable-filter-date="reset">
                    Reset Filter
                </button>
            </div>

            <?php if (isset($fieldsFilter['dateTimePicker']) && $fieldsFilter['dateTimePicker'] == true): ?>

                <div class="flex items-center" x-data="initDatePickerRange()" x-init="init()">
                    <div class="relative md:w-1/3">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input id="daterange" x-ref="picker" autocomplete="off" datepicker-format="dd/mm/yyyy"
                            data-kt-datatable-filter-input data-kt-datatable-filter data-kt-datatable-filter-date="daterange"
                            name="daterange" type="text"
                            class="daterange bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select date start">
                    </div>
                </div>
            <?php endif ?>

            <?php if (isset($fieldsFilter['custom'])) { ?>

                <div>
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">

                        <?php

                        $custom = $fieldsFilter['custom'];

                        if (is_array($custom)) {
                            $i = 0;
                            foreach ($custom as $field):
                                switch ($field['key']) {
                                    case 'select':
                                        echo view_cell('Btw\Core\Cells\Forms\SelectCell::renderList', [
                                            'label' => false,
                                            'name' => $field['name'],
                                            'byKey' => $field['byKey'] ?? false,
                                            'options' => $field['items'],
                                            'placeholder' =>  $field['placeholder'] ?? 'Choisissez',
                                            'selected' => old($field['name'], 'prospects'),
                                            'ktData' => 'data-kt-datatable-filter-custom="' . $field['name'] . '" data-kt-datatable-filter'
                                        ]);
                                        break;
                                    default:
                                        echo "i n'est ni égal à 2, ni à 1, ni à 0.";
                                }

                                $i++;
                            endforeach;
                        }
                        ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>


</div>