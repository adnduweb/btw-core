export const initHtmx = () => {
    if (typeof window.htmx !== 'undefined') {
        htmx.config.useTemplateFragments = true;
    }

    // Loadingstate.js
    let loadingStatesUndoQueue = [];

    function loadingStateContainer(target) {
        return htmx.closest(target, "[data-loading-states]") || document.body;
    }

    function mayProcessUndoCallback(target, callback) {
        if (document.body.contains(target)) {
            callback();
        }
    }

    function mayProcessLoadingStateByPath(elt, requestPath) {
        const pathElt = htmx.closest(elt, "[data-loading-path]");
        if (!pathElt) {
            return true;
        }

        return pathElt.getAttribute("data-loading-path") === requestPath;
    }

    function queueLoadingState(sourceElt, targetElt, doCallback, undoCallback) {
        const delayElt = htmx.closest(sourceElt, "[data-loading-delay]");
        if (delayElt) {
            const delayInMilliseconds =
                delayElt.getAttribute("data-loading-delay") || 2000;
            const timeout = setTimeout(() => {
                doCallback();

                loadingStatesUndoQueue.push(() => {
                    mayProcessUndoCallback(targetElt, () => undoCallback());
                });
            }, delayInMilliseconds);

            loadingStatesUndoQueue.push(() => {
                mayProcessUndoCallback(targetElt, () => clearTimeout(timeout));
            });
        } else {
            doCallback();
            loadingStatesUndoQueue.push(() => {
                mayProcessUndoCallback(targetElt, () => undoCallback());
            });
        }
    }

    function getLoadingStateElts(loadingScope, type, path) {
        return Array.from(htmx.findAll(loadingScope, `[${type}]`)).filter((elt) =>
            mayProcessLoadingStateByPath(elt, path)
        );
    }

    function getLoadingTarget(elt) {
        if (elt.getAttribute("data-loading-target")) {
            return Array.from(htmx.findAll(elt.getAttribute("data-loading-target")));
        }
        return [elt];
    }

    htmx.defineExtension("loading-states", {
        onEvent: function(name, evt) {
            if (name === "htmx:beforeRequest") {
                const container = loadingStateContainer(evt.target);

                const loadingStateTypes = [
                    "data-loading",
                    "data-loading-class",
                    "data-loading-class-remove",
                    "data-loading-disable",
                    "data-loading-aria-busy",
                ];

                let loadingStateEltsByType = {};

                loadingStateTypes.forEach((type) => {
                    loadingStateEltsByType[type] = getLoadingStateElts(
                        container,
                        type,
                        evt.detail.pathInfo.requestPath
                    );
                });

                loadingStateEltsByType["data-loading"].forEach((sourceElt) => {
                    getLoadingTarget(sourceElt).forEach((targetElt) => {
                        queueLoadingState(
                            sourceElt,
                            targetElt,
                            () =>
                            (targetElt.style.display =
                                sourceElt.getAttribute("data-loading") || "inline-block"),
                            () => (targetElt.style.display = "none")
                        );
                    });
                });

                loadingStateEltsByType["data-loading-class"].forEach((sourceElt) => {
                    const classNames = sourceElt
                        .getAttribute("data-loading-class")
                        .split(" ");

                    getLoadingTarget(sourceElt).forEach((targetElt) => {
                        queueLoadingState(
                            sourceElt,
                            targetElt,
                            () =>
                            classNames.forEach((className) =>
                                targetElt.classList.add(className)
                            ),
                            () =>
                            classNames.forEach((className) =>
                                targetElt.classList.remove(className)
                            )
                        );
                    });
                });

                loadingStateEltsByType["data-loading-class-remove"].forEach(
                    (sourceElt) => {
                        const classNames = sourceElt
                            .getAttribute("data-loading-class-remove")
                            .split(" ");

                        getLoadingTarget(sourceElt).forEach((targetElt) => {
                            // classNames.forEach((className) =>
                            //   targetElt.classList.remove(className)
                            // );

                            // setTimeout(() => {
                            //   console.log("Delayed for 42 second.");
                            //   classNames.forEach((className) =>
                            //     targetElt.classList.add(className)
                            //   );
                            // }, "2000");

                            getLoadingTarget(sourceElt).forEach((targetElt) => {
                                queueLoadingState(
                                    sourceElt,
                                    targetElt,
                                    () =>
                                    classNames.forEach((className) =>
                                        targetElt.classList.remove(className)
                                    ),
                                    () =>
                                    classNames.forEach((className) =>
                                        targetElt.classList.add(className)
                                    )
                                );
                            });
                        });
                    }
                );

                loadingStateEltsByType["data-loading-disable"].forEach((sourceElt) => {
                    getLoadingTarget(sourceElt).forEach((targetElt) => {
                        targetElt.setAttribute("disabled", true);

                        setTimeout(() => {
                            //console.log("Delayed for 4 second.");
                            targetElt.removeAttribute("disabled");
                        }, "2000");

                        //   queueLoadingState(
                        //     sourceElt,
                        //     targetElt,
                        //     () =>  targetElt.setAttribute("disabled", 'disabled'),
                        //     () =>  targetElt.removeAttribute("disabled")
                        //   );
                    });
                });

                loadingStateEltsByType["data-loading-aria-busy"].forEach((sourceElt) => {
                    getLoadingTarget(sourceElt).forEach((targetElt) => {
                        queueLoadingState(
                            sourceElt,
                            targetElt,
                            () => targetElt.setAttribute("aria-busy", "true"),
                            () => targetElt.removeAttribute("aria-busy")
                        );
                    });
                });
            }

            if (name === "htmx:beforeOnLoad") {
                while (loadingStatesUndoQueue.length > 0) {
                    loadingStatesUndoQueue.shift()();
                }
            }
        },
    });

    htmx.defineExtension("alpine-morph", {
        isInlineSwap: function(swapStyle) {
            return swapStyle === "morph";
        },
        handleSwap: function(swapStyle, target, fragment) {
            if (swapStyle === "morph") {
                if (fragment.nodeType === Node.DOCUMENT_FRAGMENT_NODE) {
                    Alpine.morph(target, fragment.firstElementChild);
                    return [target];
                } else {
                    Alpine.morph(target, fragment.outerHTML);
                    return [target];
                }
            }
        },
    });

    htmx.defineExtension("restored", {
        onEvent: function(name, evt) {
            if (name === "htmx:restored") {
                var restoredElts = evt.detail.document.querySelectorAll(
                    "[hx-trigger='restored'],[data-hx-trigger='restored']"
                );
                // need a better way to do this, would prefer to just trigger from evt.detail.elt
                var foundElt = Array.from(restoredElts).find(
                    (x) => x.outerHTML === evt.detail.elt.outerHTML
                );
                var restoredEvent = evt.detail.triggerEvent(foundElt, "restored");
            }
            return;
        },
    });

    htmx.defineExtension("json-enc", {
        onEvent: function(name, evt) {
            if (name === "htmx:configRequest") {
                evt.detail.headers["Content-Type"] = "application/json";
            }
        },

        encodeParameters: function(xhr, parameters, elt) {
            xhr.overrideMimeType("text/json");
            return JSON.stringify(parameters);
        },
    });

    htmx.defineExtension("debug", {
        onEvent: function(name, evt) {
            if (console.debug) {
                console.debug(name, evt);
            } else if (console) {
                console.log("DEBUG:", name, evt);
            } else {
                throw "NO CONSOLE SUPPORTED";
            }
        },
    });

    (function() {
        function stringifyEvent(event) {
            var obj = {};
            for (var key in event) {
                obj[key] = event[key];
            }
            return JSON.stringify(obj, function(key, value) {
                if (value instanceof Node) {
                    var nodeRep = value.tagName;
                    if (nodeRep) {
                        nodeRep = nodeRep.toLowerCase();
                        if (value.id) {
                            nodeRep += "#" + value.id;
                        }
                        if (value.classList && value.classList.length) {
                            nodeRep += "." + value.classList.toString().replace(" ", ".");
                        }
                        return nodeRep;
                    } else {
                        return "Node";
                    }
                }
                if (value instanceof Window) return "Window";
                return value;
            });
        }

        htmx.defineExtension("event-header", {
            onEvent: function(name, evt) {
                if (name === "htmx:configRequest") {
                    if (evt.detail.triggeringEvent) {
                        evt.detail.headers["Triggering-Event"] = stringifyEvent(
                            evt.detail.triggeringEvent
                        );
                    }
                }
            },
        });
    })();

    htmx.defineExtension('client-side-templates', {
        transformResponse: function(text, xhr, elt) {

            var mustacheTemplate = htmx.closest(elt, "[mustache-template]");
            if (mustacheTemplate) {
                var data = JSON.parse(text);
                var templateId = mustacheTemplate.getAttribute('mustache-template');
                var template = htmx.find("#" + templateId);
                if (template) {
                    return Mustache.render(template.innerHTML, data);
                } else {
                    throw "Unknown mustache template: " + templateId;
                }
            }

            var handlebarsTemplate = htmx.closest(elt, "[handlebars-template]");
            if (handlebarsTemplate) {
                var data = JSON.parse(text);
                var templateName = handlebarsTemplate.getAttribute('handlebars-template');
                return Handlebars.partials[templateName](data);
            }

            var nunjucksTemplate = htmx.closest(elt, "[nunjucks-template]");
            if (nunjucksTemplate) {
                var data = JSON.parse(text);
                var templateName = nunjucksTemplate.getAttribute('nunjucks-template');
                var template = htmx.find('#' + templateName);
                if (template) {
                    return nunjucks.renderString(template.innerHTML, data);
                } else {
                    return nunjucks.render(templateName, data);
                }
            }

            return text;
        }
    });

    // Disable Submit Button
    htmx.defineExtension("disable-element", {
        onEvent: function(name, evt) {
            let elt = evt.detail.elt;
            let target = elt.getAttribute("hx-disable-element");
            let targetElement = target == "self" ? elt : document.querySelector(target);

            if (name === "htmx:beforeRequest" && targetElement) {
                targetElement.disabled = true;
            } else if (name == "htmx:afterRequest" && targetElement) {
                targetElement.disabled = false;
            }
        },
    });


    htmx.defineExtension("echarts", {
        transformResponse: function(text, xhr, elt) {
            // parse json data
            var data = JSON.parse(text);

            // fetch echart element
            var option = data;
            var chartContainer = document.getElementById("charts");
            var chart = window.echarts.getInstanceByDom(chartContainer);

            // console.log(chartContainer);
            // console.log(window.echarts);
            // clean up options and update chart
            delete data.id;
            chart.setOption(option);
        },
    });

    htmx.defineExtension("reset-on-success", {
        onEvent: function(name, event) {
            if (name !== "htmx:beforeSwap") return;
            if (event.detail.isError) return;

            const triggeringElt = event.detail.requestConfig.elt;

            if (
                !triggeringElt.closest('[hx-reset-on-success="true"]') &&
                !triggeringElt.closest("[data-hx-reset-on-success]")
            )
                return;

            switch (triggeringElt.tagName) {
                case "INPUT":
                    triggeringElt.value = "";
                case "TEXTAREA":
                    // triggeringElt.value = triggeringElt.defaultValue;
                    triggeringElt.value = "";
                    break;
                case "SELECT":
                    //too much work
                    break;
                case "FORM":
                    triggeringElt.reset();
                    break;
            }
        },
    });


    const UpdateProcessWireFrontendContentUsingHtmxDemo = {
        initHTMXXRequestedWithXMLHttpRequest: function() {
            document.body.addEventListener("htmx:configRequest", (event) => {
                event.detail.headers["X-CSRF-TOKEN"] = document.querySelector("[name=X-CSRF-TOKEN]").content;
                event.detail.headers["X-Requested-With"] = "XMLHttpRequest"
            })

            document.body.addEventListener("htmx:beforeSwap", function(evt) {});

            // after settle
            htmx.on("htmx:afterSettle", function(event) {
                let contentType = event.detail.xhr.getResponseHeader("content-type");
            });

            htmx.on("htmx:afterSwap", function(evt) {
                // console.log(window);
            });

            htmx.on("htmx:afterRequest", function(evt) {
                // console.log(window);
            });

            htmx.on("htmx:responseError", function(evt) {
                // const jsonResponse = JSON.parse(evt.detail.xhr.responseText);
                let event = new CustomEvent("notify", {
                    bubbles: true,
                    cancelable: true,
                    detail: {
                        content: evt.detail.xhr.statusText,
                        type: "error",
                    },
                });
                // Emit the event
                document.dispatchEvent(event);
            });
        },

        listenToHTMXRequests: function() {
            // after settle
            htmx.on("htmx:afterSettle", function(event) {
                // RUN POST SETTLE OPS
                // @note: hidden element
                const noticeElement = document.getElementById("location_notice")
                let eventDetail = {
                    type: "error",
                    text: "Server encountered error"
                }
                // get the notice and notice type from the hidden element
                if (noticeElement) {
                    eventDetail = {
                        type: noticeElement.dataset.noticeType,
                        text: noticeElement.value,
                    }
                }
                const eventName = "notice"

                UpdateProcessWireFrontendContentUsingHtmxDemo.dispatchCustomEvent(
                    eventName,
                    eventDetail
                )
            })
        },

        getCSRFToken: function() {
            // find hidden input with 'csrf token'
            const tokenInput = htmx.find("._post_token")
            return tokenInput
        },

        /**
         * Dispatch a custom event as requrested.
         * @param {string} eventName The name of the custom event to dispatch.
         * @param {any} eventDetail The event details to attach to the event detail object.
         * @param {Node} elem Optional element to trigger the event from, else window.
         */
        dispatchCustomEvent: function(eventName, eventDetail, elem) {
            const event = new CustomEvent(eventName, {
                detail: eventDetail
            })
            if (elem) {
                elem.dispatchEvent(event)
            } else {
                window.dispatchEvent(event)
            }
        },

        // @credit: https://tailwindcomponents.com/component/alphine-js-toast-notification
        noticesHandler: function() {
            return {
                notices: [],
                visible: [],
                add(notice) {
                    notice.id = Date.now()
                    this.notices.push(notice)
                    this.fire(notice.id)
                },
                fire(id) {
                    this.visible.push(this.notices.find((notice) => notice.id == id))
                    const timeShown = 2500 * this.visible.length
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
                },
            }
        },
    }

    /**
     * DOM ready
     *
     */
    document.addEventListener("DOMContentLoaded", function(event) {
        if (typeof htmx !== "undefined") {
            // init htmx with X-Requested-With
            UpdateProcessWireFrontendContentUsingHtmxDemo.initHTMXXRequestedWithXMLHttpRequest()
            // listen to htmx requests
            UpdateProcessWireFrontendContentUsingHtmxDemo.listenToHTMXRequests()
        }
    });

    // htmx.logAll()
};
export default initHtmx;