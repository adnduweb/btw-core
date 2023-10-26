<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?= $this->section('title') ?>
<?= lang('Btw.login') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.notesList')]) ?>
<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

<?= view_cell('Btw\Core\Cells\Datatable\DatatableHeaderTable', [
        'add' => ['href' => route_to('note-create'), 'titre' => lang('Btw.addNote'), 'htmx' => ['hx-get' => route_to('note-create'), 'hx-target' => "#addnote", 'x-on:click' => '$dispatch(`modalcomponent`, {showNoteModal: true})' ]],
        'actions' => config('Note')->actionsAll,
        'filter' => [],
        'fieldsFilter' => [],
        'settings' => [],
        'import' => [],
        'export' => [],
    ]);
?>

    <div class="row justify-content-md-center">

        <div class="col-sm-12 col-lg-8">
            <?= $this->include('Btw\Core\Views\Admin\notes\table'); ?>
        </div>

    </div>
</div>


<?= $this->endSection() ?>


<?php $this->section('modals') ?>

<?= view_cell('Btw\Core\Cells\Modal::renderList', [
    'type' => 'showNoteModal',
    'name' => 'note',
    'title' => lang('Form.modal.addOrdEditInfosTech'),
    'identifier' => 'addnote',
    'view' => 'Btw\Core\Views\Admin\notes\cells\form_cell_infos_create_tech'
]); ?>

<?= view_cell('Btw\Core\Cells\Modal::renderList', [
    'type' => 'showNoteEditModal',
    'name' => 'createnote',
    'title' => lang('Form.modal.addOrdEditInfosTech'),
    'identifier' => 'createnote',
    'view' => 'Btw\Core\Views\Admin\notes\cells\form_cell_infos_edit_tech'
]); ?>

<?= view_cell('Btw\Core\Cells\Modal::renderList', [
    'type' => 'showShareNoteModal',
    'name' => 'notesharenote',
    'title' => lang('Note.modal.showShareNoteModal'),
    'identifier' => 'sharenote',
    'view' => 'Btw\Core\Views\Admin\notes\cells\form_cell_form_share'
]); ?>

<?php $this->endSection() ?>


<?php $this->section('scripts') ?>
<?= asset_link('admin/js/clipboard.min.js', 'js') ?>
<script>
    new ClipboardJS('.copyLink');
</script>
<script type="module">
    var KTnotesList = function() {
        // Define shared variables
        var table = document.getElementById('kt_table_notes');
        var datatable;
        var toolbarBase;
        var toolbarSelected;
        var rowSelected;
        var selectedCount;

        // Private functions
        var initNotesTable = function() {
            // Set date data order

            // Init datatable --- more info on datatables: https://datatables.net/manual/
            window.Ci4DataTables["kt_table_notes"] = $(table).DataTable({
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
                'headers': window.axios.defaults.headers.common,
                "ajax": {
                    "url": "<?= route_to('notes-list-ajax'); ?>",
                    'data': {
                        // CSRF Hash
                        [doudou.crsftoken]: $('meta[name="X-CSRF-TOKEN"]').attr('content'), // CSRF Token
                    },
                },
                "deferRender": true,
                'order': [
                    [1, 'asc']
                ],
                "pageLength": <?= Config('Customer')->customerLenght; ?>,
                "lengthChange": true,
                "stateSave": true,
                'rows': {
                    beforeTemplate: function(row, data, index) {

                        if (data.active == '0') {
                            row.addClass('notactive');
                        }
                        row.addClass('text-sm font-medium relative dark:hover:bg-gray-600 hover:bg-slate-50').attr('data-identifier', data.uuid);
                        row.setAttribute('hx-boost', 'true');
                    }
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('text-sm font-medium relative dark:hover:bg-gray-600 hover:bg-slate-50').attr('data-identifier', data.uuid);
                    row.setAttribute('hx-boost', 'true');
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
            echo "className: 'selection border-dashed border-t border-gray-300 px-3 text-gray-700 px-6 py-3 cursor-pointer dark:text-gray-200 relative z-10',";
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
                echo "td.setAttribute('hx-get', '/admin1198009422/notes/edit/' + rowData.identifier);
                                 td.setAttribute('x-on:click', 'new CustomEvent(`modalcomponent`, {showNoteEditModal: true})' );td.setAttribute('hx-target', '#createnote');";
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
                    htmx.process("#kt_table_notes");
                },
                drawCallback: function(settings, json) {
                    htmx.process("#kt_table_notes");
                },
            });

            // Add an event listener that updates the table whenever an htmx request completes
            // DataTables docs: https://datatables.net/reference/api/ajax.reload()
            // htmx docs: https://htmx.org/events/#htmx:afterRequest
            document.body.addEventListener('reloadTable', function(evt) {
                Ci4DataTables["kt_table_notes"].ajax.reload(function() {
                    htmx.process(table);
                }, false)
            });

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            window.Ci4DataTables["kt_table_notes"].on('draw', function(jqXHR, settings) {
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
                    Ci4DataTables["kt_table_notes"].search(e.target.value).draw();
                });
            }
        }

        const datKtDatatableFilter = document.querySelectorAll('[data-kt-datatable-filter]');
        const dataFilterDateRange = document.querySelector('[data-kt-datatable-filter-date="daterange"]');

        if (dataFilterDateRange) {
            $('[data-kt-datatable-filter]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                Ci4DataTables["kt_table_notes"].destroy();
                initNotesTable();

            });
        }

        datKtDatatableFilter.forEach(c => {
            c.addEventListener("change", (event) => {
                Ci4DataTables["kt_table_notes"].destroy();
                initNotesTable();
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
                    const userName = parent.querySelectorAll('td')[1].innerText;
                    var uuid = $(this).data('identifier');

                    Swal.fire({
                        text: "Are you sure you want to delete dd " + userName + "?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "<?= lang('Btw.deleteDatatable'); ?>",
                        cancelButtonText: "<?= lang('Btw.cancelDatatable'); ?>",
                        customClass: {
                            confirmButton: "inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-red-600 text-white hover:bg-red-500 focus:border-red-700 focus:ring-red-200 active:bg-red-600",
                            cancelButton: "inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-blue-100 text-blue-700 hover:bg-blue-200 focus:border-blue-300 focus:ring-blue-200 active:bg-blue-300 ml-2"
                        }
                    }).then(function(result) {
                        if (result.value) {

                            const packets = {
                                identifier: uuid,
                                token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                                htmx: false,
                                action: 'delete'
                            };

                            htmx.ajax('DELETE', '<?= route_to('notes-delete') ?>', {
                                values: packets
                            }).then(() => {
                                // this code will be executed after the 'htmx:afterOnLoad' event,
                                // and before the 'htmx:xhr:loadend' event
                                console.log('Content deleted successfully!');
                            });

                        } else if (result.dismiss === 'cancel') {

                            Swal.fire({
                                text: userName + "<?= lang('Btw.notDeletedDatatable'); ?>.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "<?= lang('Btw.okFinalDatatable'); ?>",
                                customClass: {
                                    confirmButton: "inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-blue-100 text-blue-700 hover:bg-blue-200 focus:border-blue-300 focus:ring-blue-200 active:bg-blue-300",
                                }
                            });
                        }
                    });
                })
            });
        }

        // Filter Datatable
        var handleFilterDateDatatable = () => {
            // Select filter options
            const filterDateStart = document.querySelector('[data-kt-datatable-filter-date="start"]');
            const filterDateEnd = document.querySelector('[data-kt-datatable-filter-date="end"]');
            const filterDateButton = document.querySelector('[data-kt-datatable-filter-date="action"]');
            const filterDateReset = document.querySelector('[data-kt-datatable-filter-date="reset"]');
            const dataFilter = document.querySelectorAll('[data-kt-datatable-filter]');

            if(filterDateReset){
                // Filæter datatable on submit
                filterDateReset.addEventListener('click', function(e) {
                    dataFilter.forEach(c => {
                        var select = c.getAttribute("data-kt-form-select");
                        if (select != null) {
                            c.value = 0;
                        } else {
                            c.value = "";
                        }
                    });
                    Ci4DataTables["kt_table_notes"].destroy();
                    initNotesTable();

                });
            }
        }


        // Init toggle toolbar
        var actionToggleToolbar = () => {

            const deleteSelected = document.querySelector('[data-kt-datatable-action="delete_selected"]');
            const activeSelected = document.querySelector('[data-kt-datatable-action="active_selected"]');
            const desactiveSelected = document.querySelector('[data-kt-datatable-action="descative_selected"]');


            // Deleted selected rows
            deleteSelected.addEventListener('click', function() {
                const identifiers = [];
                var dtRow = Ci4DataTables["kt_table_notes"].rows('.selected').data().map(function(t, e) {
                    identifiers.push(t.identifier);
                });

                Swal.fire({
                    text: _LANG_.are_you_sure_delete + " " + Ci4DataTables["kt_table_notes"].rows('.selected').data().length + " " + _LANG_.selected_records + " ?",
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

                        htmx.ajax('DELETE', '<?= route_to('notes-delete') ?>', {
                            values: packets,
                        }).then(() => {
                            // this code will be executed after the 'htmx:afterOnLoad' event,
                            // and before the 'htmx:xhr:loadend' event
                            console.log('Content deleted successfully!');
                        });
                    }
                });
            });
        }


        return {
            // Public functions  
            init: function() {
                if (!table) {
                    return;
                }

                initNotesTable();
                actionToggleToolbar();
                handleFilterDateDatatable();
                handleSearchDatatable();
            }
        }
    }(jQuery);

    KTnotesList.init();
</script>
<?php $this->endSection() ?>