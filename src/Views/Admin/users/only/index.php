<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?= $this->section('title') ?>
<?= lang('Btw.users.usersList'); ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>


<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.users.usersList')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

    <?= view_cell('Btw\Core\Cells\Datatable\DatatableHeaderTable', [
        'add' => ['href' => route_to('user-only-create'), 'titre' => lang('btw.users.addUser')],
        'actions' => $actions
    ])
    ?>

    <div class="row justify-content-md-center">

        <div class="col-sm-12 col-lg-8">
            <?= $this->include('Btw\Core\Views\Admin\users\only\table'); ?>
        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<script type="module">
    var KTUsersList = function() {
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
            window.Ci4DataTables["kt_table_users"] = $(table).DataTable({
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
                                if (!isset($column['notClick'])) :
                                    // echo "td.setAttribute('x-on:click', 'location.replace(\"/admin1198009422/users/edit/' + rowData.id + '/information\")');";
                                    echo "td.setAttribute('hx-get', '/" . ADMIN_AREA . "/users/edit/' + rowData.identifier + '/information');
                                            td.setAttribute('hx-trigger', 'click');td.setAttribute('hx-target', 'body');td.setAttribute('hx-push-url', 'true');";
                                endif;
                                echo "}";
                                echo "},";
                        }
                        ?>
                    <?php $i++;
                    endforeach; ?>
                ],
                // Use DataTables' initComplete callback to tell htmx to reprocess any htmx attributes in the table
                // DataTables docs: https://datatables.net/reference/option/initComplete
                // htmx docs: https://htmx.org/api/#process AND https://htmx.org/docs/#3rd-party
                initComplete: function(settings, json) {
                    htmx.process(table);
                },
                drawCallback: function(settings, json) {
                    htmx.process("#kt_table_users");
                },
            });


            // Add an event listener that updates the table whenever an htmx request completes
            // DataTables docs: https://datatables.net/reference/api/ajax.reload()
            // htmx docs: https://htmx.org/events/#htmx:afterRequest
            document.body.addEventListener('reloadTable', function(evt) {
                Ci4DataTables["kt_table_users"].ajax.reload(function() {
                    htmx.process('table');
                }, false)
            });

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            window.Ci4DataTables["kt_table_users"].on('draw', function(jqXHR, settings) {
                initDatatable();
                handleDeleteRows();
                actionToggleToolbar();
            });

        }

        const countSelected = (init = false) => {
            const allCheckboxes = table.querySelectorAll('tbody .selection [type="checkbox"]');

            let checkedState = false;
            let count = 0;
            allCheckboxes.forEach(c => {
                if (c.checked) {
                    checkedState = true;
                    count++;
                }
            });

            // Select elements
            let toolbarBase = document.querySelector('[data-kt-datatable-toolbar="base"]');
            let toolbarSelected = document.querySelector('[data-kt-datatable-toolbar="selected"]');
            let rowSelected = document.querySelector('[data-kt-datatable-row="selected"]');
            let selectedCount = document.querySelector('[data-kt-datatable-select="selected_count"]');

            //  // Toggle toolbars
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
            return count;
        }

        const initDatatable = () => {

            // List checkbox all click 
            const allCheck = table.querySelector('.allCheck');
            if (allCheck) {
                // Select elements
                let toolbarBase = document.querySelector('[data-kt-datatable-toolbar="base"]');
                let toolbarSelected = document.querySelector('[data-kt-datatable-toolbar="selected"]');
                let rowSelected = document.querySelector('[data-kt-datatable-row="selected"]');
                let selectedCount = document.querySelector('[data-kt-datatable-select="selected_count"]');


                allCheck.addEventListener('click', function() {
                    if (allCheck.checked) {
                        const checkboxes = table.querySelectorAll('tbody .selection [type="checkbox"]');
                        checkboxes.forEach((c, i) => {
                            c.closest('tr').classList.add('selected');
                            selectedCount.innerHTML = (i++) + 1;
                            toolbarBase.classList.add('hidden');
                            toolbarSelected.classList.remove('hidden');
                            rowSelected.classList.remove('hidden');

                            var firstRow = table.rows[0];
                            firstRow.parentNode.insertBefore(rowSelected, firstRow.rows);
                        });
                    } else {
                        const checkboxes = table.querySelectorAll('tbody .selection [type="checkbox"]');
                        checkboxes.forEach(c => {
                            c.closest('tr').classList.remove('selected');
                            toolbarBase.classList.remove('hidden');
                            toolbarSelected.classList.add('hidden');
                            rowSelected.classList.add('hidden');

                        });
                    }
                });

            }

            // Select filter options
            const groupCheckable = table.querySelectorAll('.group-checkable');
            if (groupCheckable) {
                groupCheckable.forEach(c => {
                    c.addEventListener('click', function() {
                        if (c.closest('tr').classList.contains('selected')) {
                            c.closest('tr').classList.remove('selected');
                            countSelected();
                        } else {
                            c.closest('tr').classList.add('selected');
                            countSelected();
                        }
                    });
                });
            }
        }


        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchDatatable = (datatableOnly) => {
            const filterSearch = document.querySelector('[data-kt-datatable-filter="search"]');
            if (filterSearch) {
                filterSearch.addEventListener('change', function(e) {
                    Ci4DataTables["kt_table_users"].search(e.target.value).draw();
                });
            }
        }


        const datKtDatatableFilter = document.querySelectorAll('[data-kt-datatable-filter]');
        const dataFilterDateRange = document.querySelectorAll('[data-kt-datatable-filter-date="daterange"]');

        if (dataFilterDateRange) {
            $('[data-kt-datatable-filter]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                Ci4DataTables["kt_table_users"].destroy();
                initquotesTable();

            });
        }

        datKtDatatableFilter.forEach(c => {
            c.addEventListener("change", (event) => {
                // Ci4DataTables["kt_table_users"].ajax.reload();
                Ci4DataTables["kt_table_users"].destroy();
                initquotesTable();
            });
        });


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
                    const userName = parent.querySelectorAll('td')[1].querySelectorAll('span')[0].innerText;

                    var id = $(this).data('identifier');

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
                                identifier: id,
                                token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                                htmx: false,
                                action: 'delete'
                            };

                            htmx.ajax('DELETE', '<?= route_to('users-delete') ?>', {
                                values: packets
                            }).then(() => {
                                console.log('Content deleted successfully!');
                            });

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
        var actionToggleToolbar = () => {

            const deleteSelected = document.querySelector('[data-kt-datatable-action="delete_selected"]');

            // Deleted selected rows
            if (deleteSelected) {
                deleteSelected.addEventListener('click', function() {
                    const identifiers = [];
                    var dtRow = Ci4DataTables["kt_table_users"].rows('.selected').data().map(function(t, e) {
                        identifiers.push(t.identifier);
                    });

                    Swal.fire({
                        text: _LANG_.are_you_sure_delete + " " + Ci4DataTables["kt_table_users"].rows('.selected').data().length + " " + _LANG_.selected_records + " ?",
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
                                'identifier[]': identifiers,
                                'token': $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                                'htmx': true,
                                'action': 'deleteALL'
                            };

                            htmx.ajax('DELETE', '<?= route_to('users-delete') ?>', {
                                values: packets,
                            }).then(() => {
                                console.log('Content deleted successfully!');
                            });

                        }
                    });
                });
            }
        }

        return {
            // Public functions  
            init: function() {
                if (!table) {
                    return;
                }

                initPermissionTable();
                actionToggleToolbar();
                handleSearchDatatable();
            }
        }
    }();

    KTUsersList.init();
</script>
<?php $this->endSection() ?>