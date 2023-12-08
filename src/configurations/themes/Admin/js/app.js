import { dispatch, humanFileSize } from './utils'
import { start, stop, rescan } from './lifecycle'
import { SetPhoneIntl } from './components/phoneIntl'
import jQuery from "jquery";
import intlTelInput from "intl-tel-input";
// import daterangepicker from "daterangepicker"; // A changer par un sans jquery
import flatpickr from "flatpickr";
import Datatable from "datatables.net";// A changer par un sans jquery
import "datatables.net-responsive";// A changer par un sans jquery
import EasyMDE from "easymde";// L'un ou l'autre quill
import Quill from "quill";// L'un ou l'autre easymde
import nestedSort from "nested-sort";
import select2 from 'select2';
import Alpine from 'alpinejs';
import * as htmx from "htmx.org";

let Htmxwire = {
    start,
    stop,
    rescan
}

if (window.Htmxwire) console.warn('Detected multiple instances of Htmxwire running')
if (window.Alpine) console.warn('Detected multiple instances of Alpine running')
window.htmxConfig = window.htmxConfig || {};
window.Ci4DataTables = window.Ci4DataTables || {};

// Register admin...
// import './admin'

// import './components'

import "intl-tel-input/build/css/intlTelInput.css";
import "sweetalert2/src/sweetalert2.scss";
import "/node_modules/select2/dist/css/select2.css";

// Make globals...
window.Htmxwire = Htmxwire
window.htmx = htmx;
window.Alpine = Alpine;
window.$ = window.jQuery = jQuery;
window.dispatch = dispatch;
window.humanFileSize = humanFileSize;
window.jQuery = window.$ = $;
window.intlTelInput = intlTelInput;
window.flatpickr = flatpickr;
window.datatable = Datatable;
window.EasyMDE = EasyMDE;
window.Quill = Quill;
window.nestedSort = nestedSort;
select2();
window.select2 = select2;

if (window.HtmxwireScriptConfig === undefined) {
    document.addEventListener('DOMContentLoaded', () => {
        // Start Htmxwire...
        Htmxwire.start()
    })
}

htmx.on("htmx:afterSettle", function(evt) {
    SetPhoneIntl();
});

export { Htmxwire, Alpine, htmx, dispatch, humanFileSize };
