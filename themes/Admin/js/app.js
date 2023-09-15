//This is you main entry file, Be creative =)
import "../css/app.css";

window.Ci4DataTables = window.Ci4DataTables || {};
const html = document.querySelector("html");

// Jquery
import $ from "jquery";
import intlTelInput from "intl-tel-input";
import * as FilePond from 'filepond';
import "flowbite"; // Flowbite
import "flowbite-datepicker"; // Flowbite
import Swal from "sweetalert2/dist/sweetalert2.js";
import Sortable from "sortablejs";
import axios from "axios";
import select2 from 'select2';
import daterangepicker from "daterangepicker";
import EasyMDE from "easymde";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import focus from "@alpinejs/focus";
import morph from "@alpinejs/morph";
import Clipboard from "@ryangjchandler/alpine-clipboard";
import Tooltip from "@ryangjchandler/alpine-tooltip";
import collapse from "@alpinejs/collapse";
import mask from "@alpinejs/mask";
import Datatable from "datatables.net";
import "datatables.net-responsive";
import * as echarts from "echarts";
import Dropzone from "dropzone";
import * as htmx from "htmx.org";


import "intl-tel-input/build/css/intlTelInput.css";
import 'filepond/dist/filepond.min.css';
import 'filepond/dist/filepond.min.css';
import "sweetalert2/src/sweetalert2.scss";
import "/node_modules/select2/dist/css/select2.css";

window.jQuery = window.$ = $;
window.intlTelInput = intlTelInput;
window.FilePond = FilePond;
window.Swal = Swal;
window.Sortable = Sortable;
window.axios = axios;
select2();
window.select2 = select2;
window.daterangepicker = daterangepicker;
window.EasyMDE = EasyMDE;
window.ClassicEditor = ClassicEditor;
window.Alpine = Alpine; // console.log(Alpine.version);
window.datatable = Datatable;
window.echarts = echarts;
window.dropzone = Dropzone;
window.htmx = htmx;

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

window.axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute("content")
};

Alpine.start();

import './components/util.js';
import './components/ktapp.js';
import * as SetDatatable from './components/datatable.js';
SetDatatable.initDatatable();
import * as SetPhoneIntl from './components/phoneIntl.js';
SetPhoneIntl.initPhoneIntl();
import './alpine.js';
import * as SetHtmx from "./htmx.js";
SetHtmx.initHtmx();

htmx.on("htmx:afterSettle", function(evt) {
    SetPhoneIntl.initPhoneIntl();
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
    document.querySelector(".select-all").addEventListener("click", function(e) {
        toggleSelectAll(e.target);
    });
}

// this function does run, due to HTMX's HX-Trigger-After-Swap header
// but cannot change the showDelete paramter above
document.body.addEventListener("deleteConfirmed", function(evt) {
    //console.log(evt);
    document
        .getElementById("recordSelector")
        .dispatchEvent(new CustomEvent("deleteOK"));
    // Alpine.data('showDelete', () => {showDelete = true});
});

// this function does run, due to HTMX's HX-Trigger-After-Swap header
// but cannot change the showMessage paramter above
document.body.addEventListener("showMessage", function(evt) {
    console.log(evt);
    if (typeof evt.detail.content == "object") {
        var contentRead = evt.detail.content;
        var content = "<ul>";
        Object.keys(contentRead).forEach((item) => {
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

function updateOnlineStatus(event) {
    let condition = navigator.onLine ? "online" : "offline";
    let texte = navigator.onLine ?
        "Vous êtes déconnecté du reseau" :
        "Vous êtes connecté du reseau";
    let type = navigator.onLine ? "success" : "error";

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


/***
 *
 * Modal Delete
 */

window.dispatchEvent(
    new CustomEvent("deletemodalcomponent", {
        detail: {
            showDeleteModal: false,
            title: "my-modal",
            message: "my-modal",
            id: "8",
        },
        bubbles: true,
    })
);

window.dispatchEvent(
    new CustomEvent("authdisplaydatamodalcomponent", {
        detail: {
            showAuthDisplayDataModal: false,
            title: "my-modal",
            message: "my-modal",
            id: "8",
        },
        bubbles: true,
    })
);


window.dispatchEvent(
    new CustomEvent("modalcomponent", {
        detail: {
            showModal: false,
        },
        bubbles: true,
    })
);

document.getElementById('search-field').addEventListener('keypress', function(event) {
    if (event.keyCode == 13) {
        event.preventDefault();
    }
});