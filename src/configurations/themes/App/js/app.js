//This is you main entry file, Be creative =)
import "../css/app.css";

// Jquery
import $ from "jquery";
import Swal from "sweetalert2/dist/sweetalert2.js";
import axios from "axios";
import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import focus from "@alpinejs/focus";
import morph from "@alpinejs/morph";
import Clipboard from "@ryangjchandler/alpine-clipboard";
import Tooltip from "@ryangjchandler/alpine-tooltip";
import collapse from "@alpinejs/collapse";
import mask from "@alpinejs/mask";
import * as htmx from "htmx.org";
import AOS from 'aos';
import 'aos/dist/aos.css'; // You can also use <link> for styles

window.jQuery = window.$ = $;
window.Swal = Swal;
window.axios = axios;
window.Alpine = Alpine; // console.log(Alpine.version);
window.htmx = htmx;
AOS.init({
    disable: window.innerWidth < 768,
    easing: 'ease-out-back',
    duration: 1000
});


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

window.htmxConfig.headers = {
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

if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(window.navigator.userAgent)) {
    var root = document.getElementsByTagName('html')[0];
    root.className += " no-touch";
}