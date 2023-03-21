//This is you main entry file, Be creative =)
window.Ci4DataTables = window.Ci4DataTables || {};

import $ from "jquery";
window.jQuery = window.$ = $

// ES6 Modules or TypeScript
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
window.Swal = Swal;

import axios from 'axios';
window.axios = axios;

import Datatable from 'datatables.net';
window.datatable = Datatable;

//
// Datatables.net Initialization
//

var defaults = {
    "language": {
        "info": _LANG_.Showing + " _START_ " + _LANG_.to + " _END_ " + _LANG_.of + " _TOTAL_ ",
        "infoEmpty": _LANG_.ShowingNoRecords,
        "emptyTable": _LANG_.NoDataAvailableInTable,
        "lengthMenu": "_MENU_",
        "paginate": {
            "first": '<i class="first"></i>',
            "last": '<i class="last"></i>',
            "next": '<i class="next"></i>',
            "previous": '<i class="previous"></i>'
        }
    }
};
$.extend(true, $.fn.dataTable.defaults, defaults);

var DataTable = $.fn.dataTable;


/* Set the defaults for DataTables initialisation */
$.extend(true, DataTable.defaults, {
    dom: "<'table-responsive'tr>" +

        "<'flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0'" +
        "<'text-sm font-normal text-gray-500 dark:text-gray-400 flex flex-row items-center justify-between'li>" +
        "<'inline-flex items-stretch -space-x-px'p>" +
        ">",

    renderer: 'bootstrap'
});


/* Default class modification */
$.extend(DataTable.ext.classes, {
    sWrapper: "dataTables_wrapper dt-tailwindcss",
    sFilterInput: "form-control form-control-sm form-control-solid",
    sLengthSelect: "form-select form-select-sm form-select-solid",
    sProcessing: "dataTables_processing card",
    sPageButton: "paginate_button page-item"
});


/* Bootstrap paging button renderer */
DataTable.ext.renderer.pageButton.bootstrap = function (settings, host, idx, buttons, page, pages) {
    var api = new DataTable.Api(settings);
    var classes = settings.oClasses;
    var lang = settings.oLanguage.oPaginate;
    var aria = settings.oLanguage.oAria.paginate || {};
    var btnDisplay, btnClass, counter = 0;

    var attach = function (container, buttons) {
        var i, ien, node, button;
        var clickHandler = function (e) {
            e.preventDefault();
            if (!$(e.currentTarget).hasClass('disabled') && api.page() != e.data.action) {
                api.page(e.data.action).draw('page');
            }
        };

        for (i = 0, ien = buttons.length; i < ien; i++) {
            button = buttons[i];

            if (Array.isArray(button)) {
                attach(container, button);
            } else {
                btnDisplay = '';
                btnClass = '';

                switch (button) {
                    case 'ellipsis':
                        btnDisplay = '&#x2026;';
                        btnClass = 'disabled';
                        break;

                    case 'first':
                        btnDisplay = lang.sFirst;
                        btnClass = button + (page > 0 ?
                            '' : ' disabled');
                        break;

                    case 'previous':
                        btnDisplay = lang.sPrevious;
                        btnClass = button + (page > 0 ?
                            '' : ' disabled');
                        break;

                    case 'next':
                        btnDisplay = lang.sNext;
                        btnClass = button + (page < pages - 1 ?
                            '' : ' disabled');
                        break;

                    case 'last':
                        btnDisplay = lang.sLast;
                        btnClass = button + (page < pages - 1 ?
                            '' : ' disabled');
                        break;

                    default:
                        btnDisplay = button + 1;
                        btnClass = page === button ?
                            'active' : '';
                        break;
                }

                if (btnDisplay) {
                    node = $('<li>', {
                        'class': classes.sPageButton + ' ' + btnClass,
                        'id': idx === 0 && typeof button === 'string' ?
                            settings.sTableId + '_' + button : null
                    })
                        .append($('<a>', {
                            'href': '#',
                            'aria-controls': settings.sTableId,
                            'aria-label': aria[button],
                            'data-dt-idx': counter,
                            'tabindex': settings.iTabIndex,
                            'class': 'page-link'
                        })
                            .html(btnDisplay)
                        )
                        .appendTo(container);

                    settings.oApi._fnBindAction(
                        node, { action: button }, clickHandler
                    );

                    counter++;
                }
            }
        }
    };

    // IE9 throws an 'unknown error' if document.activeElement is used
    // inside an iframe or frame.
    var activeEl;

    try {
        // Because this approach is destroying and recreating the paging
        // elements, focus is lost on the select button which is bad for
        // accessibility. So we want to restore focus once the draw has
        // completed
        activeEl = $(host).find(document.activeElement).data('dt-idx');
    } catch (e) { }

    attach(
        $(host).empty().html('<ul class="pagination"/>').children('ul'),
        buttons
    );

    if (activeEl !== undefined) {
        $(host).find('[data-dt-idx=' + activeEl + ']').trigger('focus');
    }
};

import "../css/app.css";
import "../js/ktapp.js";
import "../js/util.js";
import "../js/alpine.js";
import "../js/Htmx.js";

// $(document).on('click', '.group-checkable', function() {
// if ($(this).parent().parent().parent().hasClass('selected')) {
//     $(this).parent().parent().parent().removeClass('selected');
// } else {
//     $(this).parent().parent().parent().addClass('selected');
// }
// const groupCheckable = table.querySelector('.group-checkable'); 


/**
 * Select All checkbox for data tables
 * using plain javascript
 */
function toggleSelectAll(checkbox) {
    var table = checkbox.closest('table')
    var checkboxes = table.getElementsByTagName('input')

    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
            checkboxes[i].checked = checkbox.checked
        }
    }
}

if (document.querySelector('.select-all')) {
    document.querySelector('.select-all').addEventListener('click', function (e) {
        toggleSelectAll(e.target)
    })
}



// this function does run, due to HTMX's HX-Trigger-After-Swap header
// but cannot change the showDelete paramter above
document.body.addEventListener('deleteConfirmed', function (evt) {
    //console.log(evt);
    document.getElementById('recordSelector').dispatchEvent(new CustomEvent('deleteOK'));
    // Alpine.data('showDelete', () => {showDelete = true});
});

