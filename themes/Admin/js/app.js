//This is you main entry file, Be creative =)

import "../css/app.css";

window.Ci4DataTables = window.Ci4DataTables || {};
const html = document.querySelector("html");

import _ from "lodash";
window._ = _;

// Jquery
//with include vite transfer code to export default
import $ from "jquery";
window.jQuery = window.$ = $;


import intlTelInput from "intl-tel-input";
window.intlTelInput = intlTelInput;
import "intl-tel-input/build/css/intlTelInput.css";

// const phoneintl = document.querySelectorAll(".phoneintl");
// const country = document.querySelector('[name="country"]');

export const SettingPhoneIntl = () => {
  const phoneintl = document.querySelectorAll(".phoneintl");
  const country = document.querySelector('[name="country"]');

  if (country) {
    country.addEventListener("change", function (e) {
      //console.info(country.value);
      // iti.destroy();

      if (phoneintl) {
        phoneintl.forEach(function (e) {
          // iti.destroy();
          var iti = intlTelInput(e, {
            // separateDialCode: true,
            initialCountry: country.value,
            allowDropdown: false,
            localizedCountries: country.value,
            autoPlaceholder: "aggressive",
            placeholderNumberType: "FIXED_LINE",
            nationalMode: false,

            // utilsScript: "/intl-tel-input/js/utils.js?1684676252775",
            utilsScript:
              "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
          });

          iti.setCountry(country.value);

          e.addEventListener("countrychange", function () {
            // do something with iti.getSelectedCountryData()
            //  console.log(iti.getSelectedCountryData().iso2);
            // iti.selectCountry(country.value);

            var country = document.querySelector('[name="country"]');

            if (country) {
              // country.value = iti.getSelectedCountryData().iso2.toUpperCase();
              country.value = iti.getSelectedCountryData().dialCode;
              /// console.info(country.value);
            }
          });

          e.addEventListener("open:countrydropdown", function () {
            // triggered when the user opens the dropdown
          });

          e.addEventListener("close:countrydropdown", function () {
            // triggered when the user closes the dropdown
          });
        });
      }
    });
  }

  if (phoneintl) {
    phoneintl.forEach(function (e) {
      var iti = intlTelInput(e, {
        initialCountry: country.value ?? "US",
        // separateDialCode: true,
        allowDropdown: false,
        localizedCountries: country.value,
        autoPlaceholder: "aggressive",
        placeholderNumberType: "FIXED_LINE",
        nationalMode: false,

        // utilsScript: "/intl-tel-input/js/utils.js?1684676252775",
        utilsScript:
          "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
      });

      e.addEventListener("countrychange", function () {
        // do something with iti.getSelectedCountryData()
        //   console.log(iti.getSelectedCountryData().iso2);

        var country = document.querySelector('[name="country"]');

        if (country) {
          country.value = iti.getSelectedCountryData().iso2.toUpperCase();
          // console.info("fafa");
          // console.info(country.value);
        }
      });

      e.addEventListener("open:countrydropdown", function () {
        // triggered when the user opens the dropdown
      });

      e.addEventListener("close:countrydropdown", function () {
        // triggered when the user closes the dropdown
      });
    });

    //   input.addEventListener('telchange', function(e) {
    //     console.log(e.detail.valid); // Boolean: Validation status of the number
    //     console.log(e.detail.validNumber); // Returns internationally formatted number if number is valid and empty string if invalid
    //     console.log(e.detail.number); // Returns the user entered number, maybe auto-formatted internationally
    //     console.log(e.detail.country); // Returns the phone country iso2
    //     console.log(e.detail.countryName); // Returns the phone country name
    //     console.log(e.detail.dialCode); // Returns the dial code
    // });
  }
};

export default SettingPhoneIntl;

SettingPhoneIntl();

// console.log(window);

// const moment = require('moment');
// import * as moment from 'moment';
// import  * as fr 'moment/locale/fr';
// window.moment = moment();
// console.log(moment.locale()); // en
// console.log(momentfr);
// console.log(moment.locale()); // fr
// console.log(moment()); // fr

moment.locale(html.getAttribute("lang"));
//  console.log(moment().format('MMMM Do YYYY, h:mm:ss a')); // works fine in here only

// Flowbite
import "flowbite";
import "flowbite-datepicker";

// ES6 Modules or TypeScript
// Swal
import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/src/sweetalert2.scss";
window.Swal = Swal;

// SortableJS
import Sortable from "sortablejs";
window.Sortable = Sortable;

// Axios
import axios from "axios";
window.axios = axios;

// daterangepicker
import daterangepicker from "daterangepicker";
window.daterangepicker = daterangepicker;

import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import focus from "@alpinejs/focus";
import morph from "@alpinejs/morph";
import Clipboard from "@ryangjchandler/alpine-clipboard";
import Tooltip from "@ryangjchandler/alpine-tooltip";
import collapse from "@alpinejs/collapse";
import mask from "@alpinejs/mask";

// console.log(Alpine.version);
window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.plugin(morph);
Alpine.plugin(persist);
Alpine.plugin(Tooltip);
Alpine.plugin(mask);
Alpine.plugin(
  Clipboard.configure({
    onCopy: () => {
      console.log("Copied!");
    },
  })
);
Alpine.plugin(collapse);

// Datepicker
// import Datepicker from "flowbite-datepicker/Datepicker";
// import DateRangePicker from "flowbite-datepicker/DateRangePicker";
// import LocaleFR from "../../../node_modules/flowbite-datepicker/js/i18n/locales/fr.js";
// window.datepicker = Datepicker;
// window.dateRangePicker = DateRangePicker;
// window.LocaleFR = LocaleFR;

// function dataPicker() {
//     document.addEventListener("DOMContentLoaded", function() {
//         // Datepicker.locales.fr = LocaleFR.fr;
//         document
//             .querySelectorAll("[daterangepicker]")
//             .forEach(function(datepickerEl) {
//                 // var dateRangePicker = new daterangepicker(datepickerEl, {
//                 //     weekStart: 1,
//                 //     language: "fr",
//                 // });

//                 console.log(datepickerEl);
//                 console.log(datepickerEl.getAttribute('id'));

//                 $('#' + datepickerEl.getAttribute('id')).daterangepicker({
//                     timePicker: true,
//                     startDate: moment().startOf("hour"),
//                     endDate: moment().startOf("hour").add(32, "hour"),
//                     locale: {
//                         format: "M/DD hh:mm A"
//                     }
//                 });

//             });
//     });
// }

// dataPicker();
// document.body.addEventListener('htmx:afterOnLoad', function(evt) {
//     console.log('faf');
//     dataPicker();
// });

// Datatables
import Datatable from "datatables.net";
window.datatable = Datatable;
import "datatables.net-responsive";

// Echarts
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

          settings.oApi._fnBindAction(
            node,
            {
              action: button,
            },
            clickHandler
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

import "../js/ktapp.js";
import "../js/util.js";
import * as SetAlpine from "./Alpine.js";
SetAlpine.SettingAlpine();

Alpine.start();
import "../js/htmx.js";

import * as SetBVSelect from "./bvselect.js";
SetBVSelect.SettingBVSelect();

htmx.on("htmx:afterSettle", function (evt) {
  SettingPhoneIntl();
  SetBVSelect.SettingBVSelect();
});



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
      //   console.log(item); // key
      //   console.log(contentRead[item]); // value
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

// document.body.addEventListener("resetmodal", function (evt) {
//   console.log(evt);
//   console.log(evt.target);

//   var allInputs = evt.target.querySelectorAll("input");
//   console.log(allInputs);
//   allInputs.forEach((singleInput) => (singleInput.value = ""));
//   console.log(evt.target.querySelector("#alias"));
//   console.log(evt.target.querySelector("#alias").value);
//   evt.target.querySelector("#alias").value = "";

//   //   evt.targe.input.value = "";
// });

function select2Alpine() {
  this.select2 = $(this.$refs.select).select2();
  this.select2.on("select2:select", (event) => {
    this.selectedCity = event.target.value;
  });
  this.$watch("selectedCity", (value) => {
    this.select2.val(value).trigger("change");
  });
}

/***
 * 
 * Modal Delete
 */

window.dispatchEvent(
	new CustomEvent('deletemodalcomponent', {detail: {
    showDeleteModal : false,
    title: "my-modal", 
    message: "my-modal",
     id: '8'}, 
     'bubbles': true})
  )

  document.body.addEventListener("deletemodalcomponent", function (evt) {

	// console.log(evt);
  });