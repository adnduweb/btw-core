//This is you main entry file, Be creative =)
import "../css/app.css";

// Jquery
import $ from "jquery";
import intlTelInput from "intl-tel-input";
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


window.jQuery = window.$ = $;
window.intlTelInput = intlTelInput;
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
import './alpine.js';
import * as SetHtmx from "./htmx.js";
SetHtmx.initHtmx();


function _getElementById(el){
    return document.getElementById(el);
  }

window._getElementById = _getElementById();
