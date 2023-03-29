import '/node_modules/htmx.org/dist/htmx.js';
// general config
htmx.config.useTemplateFragments = true;

import { defineExtension } from "htmx.org";

import "../js/morph.js"
import "../js/loading-states.js"


htmx.onLoad(function(content) {
    // reinitialize your bootstrap elements here
    // console.log('onLoad');
});

// add CSRFToken to HTMX headers
document.body.addEventListener('htmx:configRequest', (event) => {
    event.detail.headers['X-CSRFToken'] = document.querySelector('[name=X-CSRF-TOKEN]').content;
})

// if an htmx request returns 204 and contains a custom statusText,
// then create a status message from the custom statusText
htmx.on('htmx:afterOnLoad', (e) => {
    let response = e.detail.xhr;
    if (response.status === 204 && response.statusText !== 'No Content') {
        hStatusMessageDisplay(e.detail.xhr.statusText);
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

htmx.defineExtension('debug', {
    onEvent: function (name, evt) {
        if (console.debug) {
            console.debug(name, evt);
        } else if (console) {
            console.log("DEBUG:", name, evt);
        } else {
            throw "NO CONSOLE SUPPORTED"
        }
    }
});

(function () {
    function stringifyEvent(event) {
        var obj = {};
        for (var key in event) {
            obj[key] = event[key];
        }
        return JSON.stringify(obj, function (key, value) {
            if (value instanceof Node) {
                var nodeRep = value.tagName;
                if (nodeRep) {
                    nodeRep = nodeRep.toLowerCase();
                    if (value.id) {
                        nodeRep += "#" + value.id;
                    }
                    if (value.classList && value.classList.length) {
                        nodeRep += "." + value.classList.toString().replace(" ", ".")
                    }
                    return nodeRep;
                } else {
                    return "Node"
                }
            }
            if (value instanceof Window) return 'Window';
            return value;
        });
    }

    htmx.defineExtension('event-header', {
        onEvent: function (name, evt) {
            if (name === "htmx:configRequest") {
                if (evt.detail.triggeringEvent) {
                    evt.detail.headers['Triggering-Event'] = stringifyEvent(evt.detail.triggeringEvent);
                }
            }
        }
    });
})();


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