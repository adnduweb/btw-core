//This is you main entry file, Be creative =)

import "../css/app.css"
console.log('la ');
import 'htmx.org';
// general config
htmx.config.useTemplateFragments = true;

import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
import { defineExtension } from "htmx.org";
Alpine.plugin(persist)

window.Alpine = Alpine;
import "../js/morph.js"
import "../js/loading-states.js"
htmx.defineExtension('json-enc', {
    onEvent: function (name, evt) {
        if (name === "htmx:configRequest") {
            evt.detail.headers['Content-Type'] = "application/json";
        }
    },

    encodeParameters: function (xhr, parameters, elt) {
        xhr.overrideMimeType('text/json');
        return (JSON.stringify(parameters));
    }
});


htmx.defineExtension('alpine-morph', {
    isInlineSwap: function (swapStyle) {
        return swapStyle === 'morph';
    },
    handleSwap: function (swapStyle, target, fragment) {
        if (swapStyle === 'morph') {
            if (fragment.nodeType === Node.DOCUMENT_FRAGMENT_NODE) {
                Alpine.morph(target, fragment.firstElementChild);
                return [target];
            } else {
                Alpine.morph(target, fragment.outerHTML);
                return [target];
            }
        }
    }
});

//Prefix alpine special attributes to pass W3C validation
document.addEventListener('alpine:init', () => {

    Alpine.data('listen', () => ({
        confirmationModal: false,
        emitTo(link, action, attributes) {
            console.log(link);
            console.log(action);
            console.log(attributes);
            this.confirmationModal = true;
        }
    }));

    Alpine.store("toasts", {
        counter: 0,
        list: [],
        createToast(message, type = "info") {
            const index = this.list.length
            let totalVisible =
                this.list.filter((toast) => {
                    return toast.visible
                }).length + 1
            this.list.push({
                id: this.counter++,
                message,
                type,
                visible: true,
            })
            setTimeout(() => {
                this.destroyToast(index)
            }, 4000 * totalVisible)
        },
        destroyToast(index) {
            this.list[index].visible = false
        },
    });

    // Alpine.prefix('data-x-')
    // Stores variable globally 
    Alpine.store('sidebar', {
        full: false,
        active: 'home',
        navOpen: false
    });
    // Creating component Dropdown
    Alpine.data('dropdown', () => ({
        open: false,
        toggle(tab) {
            this.open = !this.open;
            Alpine.store('sidebar').active = tab;
        },
        activeClass: 'bg-gray-800 text-gray-200',
        expandedClass: 'border-l border-gray-400 ml-4 pl-4',
        shrinkedClass: 'sm:absolute top-0 left-20 sm:shadow-md sm:z-10 sm:bg-gray-900 sm:rounded-md sm:p-4 border-l sm:border-none border-gray-400 ml-4 pl-4 sm:ml-0 w-28'
    }));
    // Creating component Sub Dropdown
    Alpine.data('sub_dropdown', () => ({
        sub_open: false,
        sub_toggle() {
            this.sub_open = !this.sub_open;
        },
        sub_expandedClass: 'border-l border-gray-400 ml-4 pl-4',
        sub_shrinkedClass: 'sm:absolute top-0 left-28 sm:shadow-md sm:z-10 sm:bg-gray-900 sm:rounded-md sm:p-4 border-l sm:border-none border-gray-400 ml-4 pl-4 sm:ml-0 w-28'
    }));
    // Creating tooltip
    Alpine.data('tooltip', () => ({
        show: false,
        visibleClass: 'block sm:absolute -top-7 sm:border border-gray-800 left-5 sm:text-sm sm:bg-gray-900 sm:px-2 sm:py-1 sm:rounded-md'
    }));

    Alpine.data('noticesHandler', () => ({
        notices: [],
        visible: [],
        add(notice) {
            notice.id = Date.now()
            this.notices.push(notice)
            this.fire(notice.id)
        },
        fire(id) {
            this.visible.push(this.notices.find((notice) => notice.id == id))
            const timeShown = 4500 * this.visible.length
            setTimeout(() => {
                this.remove(id)
            }, timeShown)
        },
        remove(id) {
            const notice = this.visible.find((notice) => notice.id == id)
            const index = this.visible.indexOf(notice)
            this.visible.splice(index, 1)
        },
        getIcon(notice) {
            if (notice.type == "success")
                return "<div class='text-green-500 rounded-full bg-white float-left ml-3'><svg width='1.8em' height='1.8em' viewBox='0 0 16 16' class='bi bi-check' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z'/></svg></div>"
            else if (notice.type == "info")
                return "<div class='text-blue-500 rounded-full bg-white float-left ml-3'><svg width='1.8em' height='1.8em' viewBox='0 0 16 16' class='bi bi-info' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path d='M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z'/><circle cx='8' cy='4.5' r='1'/></svg></div>"
            else if (notice.type == "warning")
                return "<div class='text-orange-500 rounded-full bg-white float-left ml-3'><svg width='1.8em' height='1.8em' viewBox='0 0 16 16' class='bi bi-exclamation' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path d='M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z'/></svg></div>"
            else if (notice.type == "error")
                return "<div class='text-red-500 rounded-full bg-white float-left ml-3'><svg width='1.8em' height='1.8em' viewBox='0 0 16 16' class='bi bi-x' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z'/><path fill-rule='evenodd' d='M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z'/></svg></div>"
        }
    }));

});


Alpine.start();


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



//https://gist.github.com/kongondo/515b80d15f8034edeb686d46752df4ec

const UpdateProcessWireFrontendContentUsingHtmxDemo = {
    initHTMXXRequestedWithXMLHttpRequest: function () {
        document.body.addEventListener("htmx:configRequest", (event) => {
            // @note: ADD THIS!!! if not using hx-include='token input'
            const csrf_token = UpdateProcessWireFrontendContentUsingHtmxDemo.getCSRFToken()
            // event.detail.headers[csrf_token.name] = csrf_token.value
            // add XMLHttpRequest to header to work with $config->ajax
            // event.detail.headers["X-Requested-With"] = "XMLHttpRequest"
            // event.detail.headers['csrf_token.name'] = document.querySelector('name[csrf_token_name]');
        })
    },

    listenToHTMXRequests: function () {
        document.body.addEventListener('htmx:beforeSwap', function (evt) {
            if (evt.detail.xhr.status === 404) {
                // alert the user when a 404 occurs (maybe use a nicer mechanism than alert())
                alert("Error: Could Not Find Resource");
            } else if (evt.detail.xhr.status === 422) {
                // allow 422 responses to swap as we are using this as a signal that
                // a form was submitted with bad data and want to rerender with the
                // errors
                //
                // set isError to false to avoid error logging in console
                evt.detail.shouldSwap = true;
                evt.detail.isError = false;
            } else if (evt.detail.xhr.status === 418) {
                // if the response code 418 (I'm a teapot) is returned, retarget the
                // content of the response to the element with the id `teapot`
                evt.detail.shouldSwap = true;
                evt.detail.target = htmx.find("#teapot");
            } else if (evt.detail.xhr.status === 403) {
                // if the response code 418 (I'm a teapot) is returned, retarget the
                // content of the response to the element with the id `teapot`
                // confirm("This page has expired.\nWould you like to refresh the page?") && window.location.reload()
            }

        });


        // after settle
        htmx.on("htmx:afterSettle", function (event) {
            let contentType = event.detail.xhr.getResponseHeader('content-type');

            if (contentType == "application/json; charset=UTF-8") {
                // console.log(event.detail.xhr.getResponseHeader('content-type'));
                //  console.log(event.detail);
                let response = JSON.parse(event.detail.xhr.response);
                // console.log(event.detail.xhr);
                // jqXHR.responseJSON

                let eventDetail = { type: "error", text: "Server encountered error" }

                if (response.messages.success) {
                    eventDetail = {
                        type: 'success',
                        text: response.messages.success,
                    }
                }

                if (response.messages.errors) {

                    let textContent = '';
                    let obj = response.messages.errors;

                    if (Object.keys(obj).length > 0) {
                        Object.keys(obj).forEach((element, index) => {
                            // current DOM element
                            // console.log(element, obj[element]);
                            textContent += '<p>' + obj[element] + '</p>';
                        });
                    }
                    eventDetail = {
                        type: 'error',
                        text: textContent,
                    }
                }


                // RUN POST SETTLE OPS
                // @note: hidden element
                // const noticeElement = document.getElementById("location_notice")
                // let eventDetail = { type: "error", text: "Server encountered error" }
                // // get the notice and notice type from the hidden element
                // if (noticeElement) {
                //     eventDetail = {
                //         type: noticeElement.dataset.noticeType,
                //         text: noticeElement.value,
                //     }
                // }
                const eventName = "notice"

                UpdateProcessWireFrontendContentUsingHtmxDemo.dispatchCustomEvent(
                    eventName,
                    eventDetail
                )
            }


        });

        htmx.on("htmx:afterSwap", function (evt) {
            // console.log(window);
        })
    },

    getCSRFToken: function () {
        // find hidden input with 'csrf token'
        const tokenInput = htmx.find(".csrf_test_name")
        return tokenInput
    },

    /**
     * Dispatch a custom event as requrested.
     * @param {string} eventName The name of the custom event to dispatch.
     * @param {any} eventDetail The event details to attach to the event detail object.
     * @param {Node} elem Optional element to trigger the event from, else window.
     */
    dispatchCustomEvent: function (eventName, eventDetail, elem) {
        const event = new CustomEvent(eventName, { detail: eventDetail })
        // console.log(event);
        if (elem) {
            elem.dispatchEvent(event)
        } else {
            window.dispatchEvent(event)
        }
    }
}

/**
 * DOM ready
 *
 */
document.addEventListener("DOMContentLoaded", function (event) {
    if (typeof htmx !== "undefined") {
        // init htmx with X-Requested-With
        UpdateProcessWireFrontendContentUsingHtmxDemo.initHTMXXRequestedWithXMLHttpRequest()
        // listen to htmx requests

        UpdateProcessWireFrontendContentUsingHtmxDemo.listenToHTMXRequests()
    }
})

// this function does run, due to HTMX's HX-Trigger-After-Swap header
// but cannot change the showDelete paramter above
document.body.addEventListener('deleteConfirmed', function (evt) {
    console.log(evt);
    document.getElementById('recordSelector').dispatchEvent(new CustomEvent('deleteOK'));
    // Alpine.data('showDelete', () => {showDelete = true});
})
