import htmx from "htmx.org";
window.htmx = htmx;
// general config
htmx.config.useTemplateFragments = true;


htmx.onLoad(function (content) {
  // reinitialize your bootstrap elements here
  // console.log('onLoad');
});


// if an htmx request returns 204 and contains a custom statusText,
// then create a status message from the custom statusText
htmx.on("htmx:afterOnLoad", (e) => {
  let response = e.detail.xhr;
  if (response.status === 204 && response.statusText !== "No Content") {
    hStatusMessageDisplay(e.detail.xhr.statusText);
  }
});

htmx.defineExtension("alpine-morph", {
  isInlineSwap: function (swapStyle) {
    return swapStyle === "morph";
  },
  handleSwap: function (swapStyle, target, fragment) {
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
  onEvent: function (name, evt) {
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
  onEvent: function (name, evt) {
    if (name === "htmx:configRequest") {
      evt.detail.headers["Content-Type"] = "application/json";
    }
  },

  encodeParameters: function (xhr, parameters, elt) {
    xhr.overrideMimeType("text/json");
    return JSON.stringify(parameters);
  },
});

htmx.defineExtension("debug", {
  onEvent: function (name, evt) {
    if (console.debug) {
      console.debug(name, evt);
    } else if (console) {
      console.log("DEBUG:", name, evt);
    } else {
      throw "NO CONSOLE SUPPORTED";
    }
  },
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
    onEvent: function (name, evt) {
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
  transformResponse : function(text, xhr, elt) {

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
  onEvent: function (name, evt) {
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
  transformResponse: function (text, xhr, elt) {
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
  onEvent: function (name, event) {
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

// https://gist.github.com/kongondo/515b80d15f8034edeb686d46752df4ec

const UpdateProcessWireFrontendContentUsingHtmxDemo = {
  initHTMXXRequestedWithXMLHttpRequest: function () {
    document.body.addEventListener("htmx:configRequest", (event) => {
      // @note: ADD THIS!!! if not using hx-include='token input'
      // const csrf_token = UpdateProcessWireFrontendContentUsingHtmxDemo.getCSRFToken()
      // event.detail.headers[csrf_token.name] = csrf_token.value
      // add XMLHttpRequest to header to work with $config->ajax
      event.detail.headers["X-CSRF-TOKEN"] = document.querySelector("[name=X-CSRF-TOKEN]").content;
      event.detail.headers["X-Requested-With"] = "XMLHttpRequest"
    });
    
    document.body.addEventListener("htmx:beforeSwap", function (evt) {});

    // after settle
    htmx.on("htmx:afterSettle", function (event) {
      window.getPhoneintl;
      let contentType = event.detail.xhr.getResponseHeader("content-type");
    });

    htmx.on("htmx:afterSwap", function (evt) {
      // console.log(window);
    });

    htmx.on("htmx:afterRequest", function (evt) {
      // console.log(window);
    });

    htmx.on("htmx:responseError", function (evt) {
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

  listenToHTMXRequests: function () {
    // after settle
    htmx.on("htmx:afterSettle", function (event) {
      // RUN POST SETTLE OPS
      // @note: hidden element
      const noticeElement = document.getElementById("location_notice")
      let eventDetail = { type: "error", text: "Server encountered error" }
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

  getCSRFToken: function () {
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
  dispatchCustomEvent: function (eventName, eventDetail, elem) {
    const event = new CustomEvent(eventName, { detail: eventDetail })
    if (elem) {
      elem.dispatchEvent(event)
    } else {
      window.dispatchEvent(event)
    }
  },


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