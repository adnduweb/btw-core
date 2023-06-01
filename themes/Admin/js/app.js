//This is you main entry file, Be creative =)
window.Ci4DataTables = window.Ci4DataTables || {};

import $ from "jquery";
window.jQuery = window.$ = $;

// ES6 Modules or TypeScript
import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/src/sweetalert2.scss";
window.Swal = Swal;

import Datepicker from "flowbite-datepicker/Datepicker";
import DateRangePicker from "flowbite-datepicker/DateRangePicker";
window.datepicker = Datepicker;
window.dateRangePicker = DateRangePicker;

import axios from "axios";
window.axios = axios;

import Datatable from "datatables.net";
window.datatable = Datatable;
import "datatables.net-responsive";

// Default SortableJS
import Sortable from 'sortablejs';
window.Sortable = Sortable;

import * as echarts from "echarts";
window.echarts = echarts;

// import tippy from 'tippy.js';
import "tippy.js/dist/tippy.css";

// If you are using JavaScript/ECMAScript modules:
import Dropzone from "dropzone";
window.dropzone = Dropzone;

window.axios.defaults.headers.common = {
  "X-Requested-With": "XMLHttpRequest",
  "X-CSRF-TOKEN": document
    .querySelector('meta[name="X-CSRF-TOKEN"]')
    .getAttribute("content"),
};

window.axios.interceptors.response.use(
  function (response) {
    return response;
  },
  function (error) {
    if (error.response) {
      // client received an error response (5xx, 4xx)
      // console.error(error.response);
      var errorDisplay = "";
      var responseTitle = error.response.statusText;
      if (error.response.data.error != undefined) {
        errorDisplay = error.response.data.error.message;
      } else {
        if (!Array.isArray(error.response.data.messages.error)) {
          errorDisplay += " - " + error.response.data.messages.error + "<br/>";
        } else {
          $.each(error.response.data.messages.error, function (innerKey, val) {
            if (val != undefined) {
              errorDisplay += " - " + val + "<br/>";
            }
          });
        }

        //var errorDisplay = error.response.data.messages.error;
      }
      toastr.error(errorDisplay, responseTitle);
    } else if (error.request) {
      // client never received a response, or request never left
      console.log(error.request);
    } else {
      // anything else
    }
    // store.commit('ERROR', error) // just taking some guesses here
    return Promise.reject(error); // this is the important part
  }
);

//
// Datatables.net Initialization
//

var defaults = {
  language: {
    info:
      _LANG_.Showing +
      " _START_ " +
      _LANG_.to +
      " _END_ " +
      _LANG_.of +
      " _TOTAL_ ",
    infoEmpty: _LANG_.ShowingNoRecords,
    emptyTable: _LANG_.NoDataAvailableInTable,
    lengthMenu: "_MENU_",
    paginate: {
      first: '<i class="first"></i>',
      last: '<i class="last"></i>',
      next: '<i class="next"></i>',
      previous: '<i class="previous"></i>',
    },
    zeroRecords: _LANG_.sZeroRecords,
    infoFiltered: "(Affichage de _MAX_ ligne(s))",
  },
};
$.extend(true, $.fn.dataTable.defaults, defaults);

var DataTable = $.fn.dataTable;

/* Set the defaults for DataTables initialisation */
$.extend(true, DataTable.defaults, {
  dom:
    "<'table-responsive'tr>" +
    "<'flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0'" +
    "<'text-sm font-normal text-gray-500 dark:text-gray-400 flex flex-row items-center justify-between'li>" +
    "<'inline-flex items-stretch -space-x-px'p>" +
    ">",

  renderer: "bootstrap",
});

/* Default class modification */
$.extend(DataTable.ext.classes, {
  sWrapper: "dataTables_wrapper dt-tailwindcss",
  sFilterInput: "form-control form-control-sm form-control-solid",
  sLengthSelect: "form-select form-select-sm form-select-solid",
  sProcessing: "dataTables_processing card",
  sPageButton: "paginate_button page-item",
});

/* Bootstrap paging button renderer */
DataTable.ext.renderer.pageButton.bootstrap = function (
  settings,
  host,
  idx,
  buttons,
  page,
  pages
) {
  var api = new DataTable.Api(settings);
  var classes = settings.oClasses;
  var lang = settings.oLanguage.oPaginate;
  var aria = settings.oLanguage.oAria.paginate || {};
  var btnDisplay,
    btnClass,
    counter = 0;

  var attach = function (container, buttons) {
    var i, ien, node, button;
    var clickHandler = function (e) {
      e.preventDefault();
      if (
        !$(e.currentTarget).hasClass("disabled") &&
        api.page() != e.data.action
      ) {
        api.page(e.data.action).draw("page");
      }
    };

    for (i = 0, ien = buttons.length; i < ien; i++) {
      button = buttons[i];

      if (Array.isArray(button)) {
        attach(container, button);
      } else {
        btnDisplay = "";
        btnClass = "";

        switch (button) {
          case "ellipsis":
            btnDisplay = "&#x2026;";
            btnClass = "disabled";
            break;

          case "first":
            btnDisplay = lang.sFirst;
            btnClass = button + (page > 0 ? "" : " disabled");
            break;

          case "previous":
            btnDisplay = lang.sPrevious;
            btnClass = button + (page > 0 ? "" : " disabled");
            break;

          case "next":
            btnDisplay = lang.sNext;
            btnClass = button + (page < pages - 1 ? "" : " disabled");
            break;

          case "last":
            btnDisplay = lang.sLast;
            btnClass = button + (page < pages - 1 ? "" : " disabled");
            break;

          default:
            btnDisplay = button + 1;
            btnClass = page === button ? "active" : "";
            break;
        }

        if (btnDisplay) {
          node = $("<li>", {
            class: classes.sPageButton + " " + btnClass,
            id:
              idx === 0 && typeof button === "string"
                ? settings.sTableId + "_" + button
                : null,
          })
            .append(
              $("<a>", {
                href: "#",
                "aria-controls": settings.sTableId,
                "aria-label": aria[button],
                "data-dt-idx": counter,
                tabindex: settings.iTabIndex,
                class: "page-link",
              }).html(btnDisplay)
            )
            .appendTo(container);

          settings.oApi._fnBindAction(node, { action: button }, clickHandler);

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
    activeEl = $(host).find(document.activeElement).data("dt-idx");
  } catch (e) {}

  attach(
    $(host).empty().html('<ul class="pagination"/>').children("ul"),
    buttons
  );

  if (activeEl !== undefined) {
    $(host)
      .find("[data-dt-idx=" + activeEl + "]")
      .trigger("focus");
  }
};

import "../css/app.css";
import "../js/ktapp.js";
import "../js/util.js";
import "../js/alpine.js";
import "../js/htmx.js";

// import htmx from 'htmx.org';
// general config
// htmx.config.useTemplateFragments = true;
// window.Htmx = htmx;
// console.log('fabrice2');
// console.log(htmx);
// import "../js/htmx.js";
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
  var table = checkbox.closest("table");
  var checkboxes = table.getElementsByTagName("input");

  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].type == "checkbox") {
      checkboxes[i].checked = checkbox.checked;
    }
  }
}

if (document.querySelector(".select-all")) {
  document.querySelector(".select-all").addEventListener("click", function (e) {
    toggleSelectAll(e.target);
  });
}

// this function does run, due to HTMX's HX-Trigger-After-Swap header
// but cannot change the showDelete paramter above
document.body.addEventListener("deleteConfirmed", function (evt) {
  //console.log(evt);
  document
    .getElementById("recordSelector")
    .dispatchEvent(new CustomEvent("deleteOK"));
  // Alpine.data('showDelete', () => {showDelete = true});
});

// this function does run, due to HTMX's HX-Trigger-After-Swap header
// but cannot change the showMessage paramter above
document.body.addEventListener("showMessage", function (evt) {
  if (typeof evt.detail.content == "object") {
    var contentRead = evt.detail.content;
    var content = "<ul>";
    Object.keys(contentRead).forEach((item) => {
      console.log(item); // key
      console.log(contentRead[item]); // value
      content += "<li>" + contentRead[item] + "</li>";
    });
    content += "</ul>";
  } else {
    content = evt.detail.content;
  }

  document.dispatchEvent(
    new CustomEvent("notify", {
      detail: {
        content: content,
        type: evt.detail.type,
      },
      bubbles: true,
    })
  );
});

if (typeof doudou != undefined) {
  var timeoutInMiliseconds = import.meta.env.VITE_SESSION_EXPIRATION * 1000; // 60000
  var timeoutId;

  function startTimer() {
    // window.setTimeout returns an Id that can be used to start and stop a timer

    timeoutId = window.setTimeout(doInactive, timeoutInMiliseconds);
  }

  function doInactive() {
    Alpine.store("openmodal", true);

    document.addEventListener("closemodal", () => {
      Alpine.store("openmodal", false);
      location.reload();
      // clear modal content here if you want
    });

    // does whatever you need it to actually do - probably signs them out or stops polling the server for info
  }

  function resetTimer() {
    window.clearTimeout(timeoutId);
    startTimer();
  }

  function setupTimers() {
    document.addEventListener("mousemove", resetTimer, false);
    document.addEventListener("mousedown", resetTimer, false);
    document.addEventListener("keypress", resetTimer, false);
    document.addEventListener("touchmove", resetTimer, false);

    startTimer();
  }

  window.addEventListener("load", function (event) {
    // do some other initialization

    setupTimers();
  });
}

function updateOnlineStatus(event) {
  let condition = navigator.onLine ? "online" : "offline";
  let texte = navigator.onLine
    ? "Vous êtes déconnecté du reseau"
    : "Vous êtes connecté du reseau";
  let type = navigator.onLine ? "success" : "error";

  //   console.log("Event: " + event.type, " Status: " + condition);

  if (event.type != undefined) {
    document.dispatchEvent(
      new CustomEvent("notify", {
        detail: {
          content: condition,
          type: type,
        },
        bubbles: true,
      })
    );
  }
}
window.addEventListener("online", updateOnlineStatus);
window.addEventListener("offline", updateOnlineStatus);

updateOnlineStatus({}); //set initial status

htmx.defineExtension("echarts", {
  transformResponse: function (text, xhr, elt) {
      // parse json data 
    var data = JSON.parse(text);

    // fetch echart element
    var option = data;
    var chartContainer = document.getElementById(data.id);
    var chart = echarts.init(chartContainer);

    delete data.id;
    chart.setOption(option);
    return text;
  },
});
