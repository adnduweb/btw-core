<?= $this->extend('Themes\Admin\master') ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head> <?= lang('Btw.UsersList'); ?> </x-page-head>
<x-admin-box>
    <div class="mb-4 flex justify-between items-center">
        <!--begin::Card title-->
        <div class="flex-1 pr-4">
            <!--begin::Search-->
            <div class="relative md:w-1/3">
                <input type="text" data-kt-users-table-filter="search" class="w-full pl-10 pr-4 py-2 border-gray-300 dark:border-transparent rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-400 dark:bg-gray-700 font-medium" placeholder="<?= lang('Core.search'); ?>" />
                <div class="absolute top-0 left-0 inline-flex items-center p-2">
                    <?= service('theme')->getSVG('duotone/General/Search.svg', "svg-icon svg-icon-1 position-absolute ms-6"); ?>
                </div>
            </div>
            <!--end::Search-->
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">

            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-users-table-toolbar="base">


            </div>
            <!--end::Toolbar-->

            <!--begin::Group actions-->
            <div class="d-flex justify-content-end align-items-center hidden" data-kt-users-table-toolbar="selected">
                <div class="fw-bolder me-5">
                    <!-- <span class="me-2" data-kt-users-table-select="selected_count"></span><?= lang('Core.selected'); ?> -->
                </div>
                <div class="shadow rounded-lg flex">
                    <div class="relative">
                        <button @click.prevent="open = !open" class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <path d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5"></path>
                            </svg>
                            <span class="hidden md:block">Action</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="z-40 absolute top-0 right-0 w-40 bg-white rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden" style="display: none;">

                            <div class="flex flex-col justify-between items-center text-truncate hover:bg-gray-100 px-4 py-2">
                                <button type="button" class="w-full flex justify-start" data-kt-users-table-action="delete_selected">
                                    <?= service('theme')->getSVG('duotone/General/Search.svg', "svg-icon svg-icon-1 position-absolute ms-6"); ?>
                                    <span><?= lang('Btw.delete'); ?></span>
                                </button>
                            </div>
                            <div class="flex flex-col justify-between items-center text-truncate hover:bg-gray-100 px-4 py-2">
                                <button type="button" class="w-full flex justify-start" data-kt-users-table-action="active_selected">
                                    <?= service('theme')->getSVG('duotone/General/Search.svg', "svg-icon svg-icon-1 position-absolute ms-6"); ?>
                                    <span><?= lang('Btw.active'); ?></span>
                                </button>
                            </div>
                            <div class="flex flex-col justify-between items-center text-truncate hover:bg-gray-100 px-4 py-2">

                                <button type="button" class="w-full flex justify-start" data-kt-users-table-action="descative_selected">
                                    <?= service('theme')->getSVG('duotone/General/Search.svg', "svg-icon svg-icon-1 position-absolute ms-6"); ?>
                                    <span><?= lang('Btw.desactive'); ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Group actions-->

    </div>
    <!--end::Card toolbar-->

    </div>

    <div class="row justify-content-md-center">

        <div class="col-sm-12 col-lg-8">
            <?= $this->include('Btw\Core\Views\Admin\users\only\table'); ?>
        </div>

    </div>

</x-admin-box>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    // Set the checkbox to be checked from the start 
    // to end when the user presses the shift key.
    function checkRange(event) {
        let checkboxes = document.getElementsByName('selection');
        let inBetween = false;
        if (event.shiftKey && event.target.checked) {
            checkboxes.forEach(checkbox => {
                if (checkbox === event.target || checkbox === last_checked) {
                    inBetween = !inBetween;
                }
                if (inBetween) {
                    checkbox.checked = true;
                }
            });
        }
        last_checked = event.target;
    }

    function toggleColumn(key) {
        console.log(key);
    }
</script>
<?php $this->endSection() ?>


<?php $this->section('scriptsUrl') ?>

<!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> -->
<!-- <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script> -->
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script type="module">
    var KTPermissionsList = function() {
        // Define shared variables
        var table = document.getElementById('kt_table_users');
        var datatable;
        var toolbarBase;
        var toolbarSelected;
        var rowSelected;
        var selectedCount;

        // Private functions
        var initPermissionTable = function() {
            // Set date data order

            // Init datatable --- more info on datatables: https://datatables.net/manual/
            window.Ci4DataTables["kt_table_users-table"] = $(table).DataTable({
                'responsive': true,
                "info": true,
                "retrieve": true,
                'selectRow': true,
                "select": {
                    style: 'multi',
                    selector: 'td:first-child .checkable',
                },
                "autoWidth": false,
                "serverSide": true,
                "processing": true,
                'searchDelay': 400,
                'serverMethod': 'get',
                // 'headers': window.axios.defaults.headers.common,
                // 'language': {
                //     // 'noRecords': _LANG_.no_record_found,
                // },
                "ajax": {
                    "url": "<?= route_to('users-list-ajax'); ?>"
                },
                'order': [
                    [1, 'asc']
                ],
                "pageLength": 10,
                "lengthChange": true,
                "stateSave": true,
                'rows': {
                    beforeTemplate: function(row, data, index) {

                        if (data.active == '0') {
                            row.addClass('notactive');
                        }
                        row.addClass(' text-sm font-medium relative dark:hover:bg-gray-600 hover:bg-slate-50 ');
                    }
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass(' text-sm font-medium relative dark:hover:bg-gray-600 hover:bg-slate-50 ');
                },

                columnDefs: [{
                        targets: 0,
                        orderable: false,
                        className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200'
                    }, {
                        targets: 1,
                        orderable: false,
                        className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200'
                    },
                    {
                        targets: 2,
                        orderable: false,
                        className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200'
                    },
                    {
                        targets: 3,
                        orderable: false,
                        className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200'
                    },
                    {
                        targets: 4,
                        orderable: false,
                        className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200'
                    },
                    {
                        targets: 5,
                        orderable: false,
                        className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200'
                    },
                    {
                        targets: 6,
                        orderable: false,
                        className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200'
                    },
                    // {
                    //     targets: 7,
                    //     orderable: false,
                    //     className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200'
                    // },
                    // {
                    //     targets: 8,
                    //     orderable: false,
                    //     className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200'
                    // },
                    {
                        targets: -1,
                        orderable: false,
                        className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200'
                    }, //target -1 means last column
                ]
            });

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            window.Ci4DataTables["kt_table_users-table"].on('draw', function(jqXHR, settings) {
                initToggleToolbar();
                handleDeleteRows();
                toggleToolbars();
                handleSelectedRowDatatable();
            });

        }

        const allCheck = table.querySelector('.allCheck');
        allCheck.addEventListener('click', function() {
            const checkboxes = table.querySelectorAll('tbody [type="checkbox"]');
            checkboxes.forEach(c => {
                if (c.closest('tr').classList.contains('bg-blue-50')) {
                    c.closest('tr').classList.remove('bg-blue-50');
                } else {
                    c.closest('tr').classList.add('bg-blue-50');
                }
            });
        });

        // Filter Datatable
        var handleSelectedRowDatatable = () => {
            // Select filter options
            const groupCheckable = table.querySelectorAll('.group-checkable');
            groupCheckable.forEach(c => {
                c.addEventListener('click', function() {
                    if (c.closest('tr').classList.contains('bg-blue-50')) {
                        c.closest('tr').classList.remove('bg-blue-50');
                    } else {
                        c.closest('tr').classList.add('bg-blue-50');
                    }
                });
            });
        }


        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchDatatable = () => {
            const filterSearch = document.querySelector('[data-kt-users-table-filter="search"]');
            filterSearch.addEventListener('change', function(e) {
                Ci4DataTables["kt_table_users-table"].search(e.target.value).draw();
            });
        }

        // Filter Datatable
        var handleFilterDatatable = () => {
            // Select filter options
            const filterForm = document.querySelector('[data-kt-users-table-filter="form"]');
            const filterButton = filterForm.querySelector('[data-kt-users-table-filter="filter"]');
            const selectOptions = filterForm.querySelectorAll('select');

            // Filter datatable on submit
            filterButton.addEventListener('click', function() {
                var filterString = '';

                // Get filter values
                selectOptions.forEach((item, index) => {
                    if (item.value && item.value !== '') {
                        if (index !== 0) {
                            filterString += ' ';
                        }
                        // Build filter value options
                        filterString += item.value;
                    }
                });

                // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
                Ci4DataTables["kt_table_users-table"].search(filterString).draw();
            });
        }

        // Reset Filter
        var handleResetForm = () => {
            // Select reset button
            const resetButton = document.querySelector('[data-kt-users-table-filter="reset"]');

            // Reset datatable
            resetButton.addEventListener('click', function() {
                // Select filter options
                const filterForm = document.querySelector('[data-kt-users-table-filter="form"]');
                const selectOptions = filterForm.querySelectorAll('select');

                // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items
                selectOptions.forEach(select => {
                    $(select).val('').trigger('change');
                });

                // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
                Ci4DataTables["kt_table_users-table"].search('').draw();
            });
        }


        // Delete subscirption
        var handleDeleteRows = () => {
            // Select all delete buttons
            const deleteButtons = table.querySelectorAll('[data-kt-users-table-filter="delete_row"]');


            deleteButtons.forEach(d => {
                // Delete button on click
                d.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Select parent row
                    const parent = e.target.closest('tr');

                    // Get user name
                    const userName = parent.querySelectorAll('td')[1].querySelectorAll('span')[0].innerText;

                    var id = $(this).data('id');

                    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/

                    // const swalWithBootstrapButtons = Swal.mixin({
                    //     customClass: {
                    //         confirmButton: 'btn btn-success',
                    //         cancelButton: 'btn btn-danger'
                    //     },
                    //     buttonsStyling: false
                    // })
                    Swal.fire({
                        text: "Are you sure you want to delete dd " + userName + "?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-red-600 text-white hover:bg-red-500 focus:border-red-700 focus:ring-red-200 active:bg-red-600",
                            cancelButton: "inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-blue-100 text-blue-700 hover:bg-blue-200 focus:border-blue-300 focus:ring-blue-200 active:bg-blue-300 ml-2"
                        }
                    }).then(function(result) {
                        if (result.value) {

                            const packets = {
                                id: [id],
                                token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                            };

                            axios.delete("<?= route_to('users-delete') ?>", {
                                    data: packets
                                })
                                .then(response => {
                                    // toastr.success(response.data.messages.success);
                                    console.log('fafafffffffafa');
                                    // const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                                    // headerCheckbox.checked = false;

                                    console.log(response);
                                    var alerts = document.querySelector('#alerts-wrapper');
                                    alerts.insertAdjacentHTML("beforeend", response.data.messagehtml);
                                    Ci4DataTables["kt_table_users-table"].ajax.reload();

                                })
                                .catch(error => {});

                        } else if (result.dismiss === 'cancel') {

                            Swal.fire({
                                text: userName + " was not deleted.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-blue-100 text-blue-700 hover:bg-blue-200 focus:border-blue-300 focus:ring-blue-200 active:bg-blue-300",
                                }
                            });
                        }
                    });
                })
            });
        }

        // Init toggle toolbar
        var initToggleToolbar = () => {
            // Toggle selected action toolbar
            // Select all checkboxes
            const checkboxes = table.querySelectorAll('[type="checkbox"]');

            // Select elements
            toolbarBase = document.querySelector('[data-kt-users-table-toolbar="base"]');
            toolbarSelected = document.querySelector('[data-kt-users-table-toolbar="selected"]');
            rowSelected = document.querySelector('[data-kt-users-table-row="selected"]');
            selectedCount = document.querySelector('[data-kt-users-table-select="selected_count"]');
            const deleteSelected = document.querySelector('[data-kt-users-table-action="delete_selected"]');

            // Toggle delete selected toolbar
            checkboxes.forEach(c => {
                // Checkbox on click event
                c.addEventListener('click', function() {
                    setTimeout(function() {
                        toggleToolbars();
                    }, 50);
                });
            });


            // Deleted selected rows
            deleteSelected.addEventListener('click', function() {
                const ids = [];
                var dtRow = Ci4DataTables["kt_table_users-table"].rows('.selected').data().map(function(t, e) {
                    ids.push(t.id);
                });

                Swal.fire({
                    text: _LANG_.are_you_sure_delete + " " + Ci4DataTables["kt_table_users-table"].rows('.selected').data().length + " " + _LANG_.selected_records + " ?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: _LANG_.yes_delete + ' !',
                    cancelButtonText: _LANG_.no_cancel,
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function(result) {
                    if (result.value) {
                        const packets = {
                            id: ids,
                            token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                        };

                        axios.delete("<?= route_to('users-delete') ?>", {
                                data: packets
                            })
                            .then(response => {
                                // toastr.success(response.data.messages.success);
                                console.log('fabrice');
                                const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                                headerCheckbox.checked = false;
                                Ci4DataTables["kt_table_users-table"].ajax.reload();
                            })
                            .catch(error => {});
                    }
                });
            });
        }

        // Toggle toolbars
        const toggleToolbars = () => {
            // Select refreshed checkbox DOM elements 
            const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');

            // Detect checkboxes state & count
            let checkedState = false;
            let count = 0;

            // Count checked boxes
            allCheckboxes.forEach(c => {
                if (c.checked) {
                    checkedState = true;
                    count++;
                }
            });

            // Toggle toolbars
            if (checkedState) {
                selectedCount.innerHTML = count;
                toolbarBase.classList.add('hidden');
                toolbarSelected.classList.remove('hidden');
                rowSelected.classList.remove('hidden');
            } else {
                toolbarBase.classList.remove('hidden');
                toolbarSelected.classList.add('hidden');
                rowSelected.classList.add('hidden');
            }
        }

        return {
            // Public functions  
            init: function() {
                if (!table) {
                    return;
                }

                initPermissionTable();
                initToggleToolbar();
                handleSearchDatatable();
            }
        }
    }();

    // On document ready
    //KTUtil.onDOMContentLoaded(function() {
    KTPermissionsList.init();
    //});
</script>
<?php $this->endSection() ?>