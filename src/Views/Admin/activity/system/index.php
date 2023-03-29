<?= $this->extend('Themes\Admin\master') ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head> <?= lang('Btw.LogsSystemList'); ?> </x-page-head>
<x-admin-box>

    <?= $this->include('Themes\Admin\Datatabase\_headerTable'); ?>

    <div class="row justify-content-md-center">

        <div class="col-sm-12 col-lg-8">
            <?= $this->include('Btw\Core\Views\Admin\activity\system\table'); ?>
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
</script>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script type="module">
    var KTPermissionsList = function() {
        // Define shared variables
        var table = document.getElementById('kt_table_system');
        var datatable;
        var toolbarBase;
        var toolbarSelected;
        var rowSelected;
        var selectedCount;

        // Private functions
        var initPermissionTable = function() {
            // Set date data order

            // Init datatable --- more info on datatables: https://datatables.net/manual/
            window.Ci4DataTables["kt_table_system-table"] = $(table).DataTable({
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
                    "url": "<?= route_to('logs-system-ajax'); ?>"
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
                        row.addClass('text-sm font-medium relative dark:hover:bg-gray-600 hover:bg-slate-50 ');
                    }
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('text-sm font-medium relative dark:hover:bg-gray-600 hover:bg-slate-50 ');
                },

                columnDefs: [
                    <?php $i = 0;
                    foreach ($columns as $column) : ?>
                        <?php
                        switch ($column['name']) {
                            case 'selection':
                                echo "{";
                                echo "data: 'select',";
                                echo "targets: 0,";
                                echo "orderable: false,";
                                echo "className: 'selection border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200 relative z-50',";
                                if (isset($column['responsivePriority'])) :
                                    echo "responsivePriority: " . $column['responsivePriority'];
                                endif;
                                echo "},";
                                break;
                            case 'action':
                                echo "{";
                                echo "data: 'action',";
                                echo "targets: -1,";
                                echo "orderable: false,";
                                echo "className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200 relative',";
                                if (isset($column['responsivePriority'])) :
                                    echo "responsivePriority: " . $column['responsivePriority'];
                                endif;
                                echo "}";
                                break;
                            default:
                                echo "{";
                                echo "data: '" . $column['name'] . "',";
                                echo "targets: $i, ";
                                echo "orderable: " . $column['orderable'] . ",";
                                echo "className: 'border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200 relative',";
                                if (isset($column['responsivePriority'])) :
                                    echo "responsivePriority: " . $column['responsivePriority'] . ", ";
                                endif;
                                echo "createdCell: function(td, cellData, rowData, row, col) {";
                                echo "td.setAttribute('x-on:click', 'location.replace(\"/admin1198009422/page/edit/' + rowData.id + '/information\")');";
                                echo "}";
                                echo "},";
                        }
                        ?>
                    <?php $i++;
                    endforeach; ?>
                ]
            });

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            window.Ci4DataTables["kt_table_system-table"].on('draw', function(jqXHR, settings) {
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
                if (c.closest('tr').classList.contains('bg-sky-700')) {
                    c.closest('tr').classList.remove('bg-sky-700', 'dark:bg-gray-800', 'selected');
                } else {
                    c.closest('tr').classList.add('bg-sky-700', 'dark:bg-gray-800', 'selected');
                }
            });
        });

        // Filter Datatable
        var handleSelectedRowDatatable = () => {
            // Select filter options
            const groupCheckable = table.querySelectorAll('.group-checkable');
            groupCheckable.forEach(c => {
                c.addEventListener('click', function() {
                    if (c.closest('tr').classList.contains('bg-sky-700')) {
                        c.closest('tr').classList.remove('bg-sky-700', 'dark:bg-gray-800', 'selected');
                    } else {
                        c.closest('tr').classList.add('bg-sky-700', 'dark:bg-gray-800', 'selected');
                    }
                });
            });
        }


        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchDatatable = () => {
            const filterSearch = document.querySelector('[data-kt-datatable-filter="search"]');
            filterSearch.addEventListener('change', function(e) {
                Ci4DataTables["kt_table_system-table"].search(e.target.value).draw();
            });
        }

        // Filter Datatable
        var handleFilterDatatable = () => {
            // Select filter options
            const filterForm = document.querySelector('[data-kt-datatable-filter="form"]');
            const filterButton = filterForm.querySelector('[data-kt-datatable-filter="filter"]');
            const selectOptions = filterForm.querySelectorAll('select');

            // Filæter datatable on submit
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
                Ci4DataTables["kt_table_system-table"].search(filterString).draw();
            });
        }

        // Reset Filter
        var handleResetForm = () => {
            // Select reset button
            const resetButton = document.querySelector('[data-kt-datatable-filter="reset"]');

            // Reset datatable
            resetButton.addEventListener('click', function() {
                // Select filter options
                const filterForm = document.querySelector('[data-kt-datatable-filter="form"]');
                const selectOptions = filterForm.querySelectorAll('select');

                // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items
                selectOptions.forEach(select => {
                    $(select).val('').trigger('change');
                });

                // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
                Ci4DataTables["kt_table_system-table"].search('').draw();
            });
        }


        // Delete subscirption
        var handleDeleteRows = () => {
            // Select all delete buttons
            const deleteButtons = table.querySelectorAll('[data-kt-datatable-filter="delete_row"]');


            deleteButtons.forEach(d => {
                // Delete button on click
                d.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Select parent row
                    const parent = e.target.closest('tr');

                    // Get user name
                    const userName = parent.querySelectorAll('td')[1].innerText;
                    var id = $(this).data('id');

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

                            axios.delete("<?= route_to('logs-system-delete') ?>", {
                                    data: packets
                                })
                                .then(response => {
                                    var alerts = document.querySelector('#alerts-wrapper');
                                    alerts.insertAdjacentHTML("beforeend", response.data.messagehtml);
                                    Ci4DataTables["kt_table_system-table"].ajax.reload();

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
            toolbarBase = document.querySelector('[data-kt-datatable-toolbar="base"]');
            toolbarSelected = document.querySelector('[data-kt-datatable-toolbar="selected"]');
            rowSelected = document.querySelector('[data-kt-datatable-row="selected"]');
            selectedCount = document.querySelector('[data-kt-datatable-select="selected_count"]');
            const deleteSelected = document.querySelector('[data-kt-datatable-action="delete_selected"]');

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
                var dtRow = Ci4DataTables["kt_table_system-table"].rows('.selected').data().map(function(t, e) {
                    console.log(t.id);
                    ids.push(t.id);
                });

                Swal.fire({
                    text: _LANG_.are_you_sure_delete + " " + Ci4DataTables["kt_table_system-table"].rows('.selected').data().length + " " + _LANG_.selected_records + " ?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: _LANG_.yes_delete + ' !',
                    cancelButtonText: _LANG_.no_cancel,
                    customClass: {
                        confirmButton: "inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-red-600 text-white hover:bg-red-500 focus:border-red-700 focus:ring-red-200 active:bg-red-600",
                        cancelButton: "inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-blue-100 text-blue-700 hover:bg-blue-200 focus:border-blue-300 focus:ring-blue-200 active:bg-blue-300 ml-2"
                    }
                }).then(function(result) {
                    if (result.value) {
                        const packets = {
                            id: ids,
                            token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                        };

                        axios.delete("<?= route_to('logs-system-delete') ?>", {
                                data: packets
                            })
                            .then(response => {
                                // toastr.success(response.data.messages.success);
                                console.log('fabrice');
                                const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                                headerCheckbox.checked = false;
                                Ci4DataTables["kt_table_system-table"].ajax.reload();
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
                var firstRow = table.rows[0];
                firstRow.parentNode.insertBefore(rowSelected, firstRow.rows);
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