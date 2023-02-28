(function(e, t) {
    if (typeof define === "function" && define.amd) {
        define([], t)
    } else {
        e.Idiomorph = e.Idiomorph || t()
    }
}
)(typeof self !== "undefined" ? self : this, function() {
    return function() {
        "use strict";
        let o = new Set;
        function e(e, t, n={}) {
            if (e instanceof Document) {
                e = e.documentElement
            }
            if (typeof t === "string") {
                t = v(t)
            }
            let l = S(t);
            let r = s(e, l, n);
            return d(e, l, r)
        }
        function d(r, i, o) {
            if (o.head.block) {
                let t = r.querySelector("head");
                let n = i.querySelector("head");
                if (t && n) {
                    let e = f(n, t, o);
                    Promise.all(e).then(function() {
                        d(r, i, Object.assign(o, {
                            head: {
                                block: false,
                                ignore: true
                            }
                        }))
                    });
                    return
                }
            }
            if (o.morphStyle === "innerHTML") {
                l(i, r, o);
                return r.children
            } else if (o.morphStyle === "outerHTML" || o.morphStyle == null) {
                let e = A(i, r, o);
                let t = e?.previousSibling;
                let n = e?.nextSibling;
                let l = a(r, e, o);
                if (e) {
                    return y(t, l, n)
                } else {
                    return []
                }
            } else {
                throw "Do not understand how to morph style " + o.morphStyle
            }
        }
        function a(e, t, n) {
            if (n.ignoreActive && e === document.activeElement) {} else if (t == null) {
                n.callbacks.beforeNodeRemoved(e);
                e.remove();
                n.callbacks.afterNodeRemoved(e);
                return null
            } else if (!h(e, t)) {
                n.callbacks.beforeNodeRemoved(e);
                n.callbacks.beforeNodeAdded(t);
                e.parentElement.replaceChild(t, e);
                n.callbacks.afterNodeAdded(t);
                n.callbacks.afterNodeRemoved(e);
                return t
            } else {
                n.callbacks.beforeNodeMorphed(e, t);
                if (e instanceof HTMLHeadElement && n.head.ignore) {} else if (e instanceof HTMLHeadElement && n.head.style !== "morph") {
                    f(t, e, n)
                } else {
                    r(t, e);
                    l(t, e, n)
                }
                n.callbacks.afterNodeMorphed(e, t);
                return e
            }
        }
        function l(n, l, r) {
            let e = n.firstChild;
            let i = l.firstChild;
            while (e) {
                let t = e;
                e = t.nextSibling;
                if (i == null) {
                    r.callbacks.beforeNodeAdded(t);
                    l.appendChild(t);
                    r.callbacks.afterNodeAdded(t)
                } else if (c(t, i, r)) {
                    a(i, t, r);
                    i = i.nextSibling
                } else {
                    let e = b(n, l, t, i, r);
                    if (e) {
                        i = m(i, e, r);
                        a(e, t, r)
                    } else {
                        let e = g(n, l, t, i, r);
                        if (e) {
                            i = m(i, e, r);
                            a(e, t, r)
                        } else {
                            r.callbacks.beforeNodeAdded(t);
                            l.insertBefore(t, i);
                            r.callbacks.afterNodeAdded(t)
                        }
                    }
                }
                T(r, t)
            }
            while (i !== null) {
                let e = i;
                i = i.nextSibling;
                N(e, r)
            }
        }
        function r(n, l) {
            let e = n.nodeType;
            if (e === 1) {
                const t = n.attributes;
                const r = l.attributes;
                for (const i of t) {
                    if (l.getAttribute(i.name) !== i.value) {
                        l.setAttribute(i.name, i.value)
                    }
                }
                for (const o of r) {
                    if (!n.hasAttribute(o.name)) {
                        l.removeAttribute(o.name)
                    }
                }
            }
            if (e === 8 || e === 3) {
                if (l.nodeValue !== n.nodeValue) {
                    l.nodeValue = n.nodeValue
                }
            }
            if (n instanceof HTMLInputElement && l instanceof HTMLInputElement && n.type !== "file") {
                let e = n.value;
                let t = l.value;
                u(n, l, "checked");
                u(n, l, "disabled");
                if (!n.hasAttribute("value")) {
                    l.value = "";
                    l.removeAttribute("value")
                } else if (e !== t) {
                    l.setAttribute("value", e);
                    l.value = e
                }
            } else if (n instanceof HTMLOptionElement) {
                u(n, l, "selected")
            } else if (n instanceof HTMLTextAreaElement && l instanceof HTMLTextAreaElement) {
                let e = n.value;
                let t = l.value;
                if (e !== t) {
                    l.value = e
                }
                if (l.firstChild && l.firstChild.nodeValue !== e) {
                    l.firstChild.nodeValue = e
                }
            }
        }
        function u(e, t, n) {
            if (e[n] !== t[n]) {
                t[n] = e[n];
                if (e[n]) {
                    t.setAttribute(n, "")
                } else {
                    t.removeAttribute(n)
                }
            }
        }
        function f(e, t, l) {
            let r = [];
            let i = [];
            let o = [];
            let d = [];
            let a = l.head.style;
            let u = new Map;
            for (const n of e.children) {
                u.set(n.outerHTML, n)
            }
            for (const s of t.children) {
                let e = u.has(s.outerHTML);
                let t = l.head.shouldReAppend(s);
                let n = l.head.shouldPreserve(s);
                if (e || n) {
                    if (t) {
                        i.push(s)
                    } else {
                        u.delete(s.outerHTML);
                        o.push(s)
                    }
                } else {
                    if (a === "append") {
                        if (t) {
                            i.push(s);
                            d.push(s)
                        }
                    } else {
                        if (l.head.shouldRemove(s) !== false) {
                            i.push(s)
                        }
                    }
                }
            }
            d.push(...u.values());
            p("to append: ", d);
            let f = [];
            for (const c of d) {
                p("adding: ", c);
                let n = document.createRange().createContextualFragment(c.outerHTML).firstChild;
                p(n);
                if (l.callbacks.beforeNodeAdded(n) !== false) {
                    if (n.href || n.src) {
                        let t = null;
                        let e = new Promise(function(e) {
                            t = e
                        }
                        );
                        n.addEventListener("load", function() {
                            t()
                        });
                        f.push(e)
                    }
                    t.appendChild(n);
                    l.callbacks.afterNodeAdded(n);
                    r.push(n)
                }
            }
            for (const h of i) {
                if (l.callbacks.beforeNodeRemoved(h) !== false) {
                    t.removeChild(h);
                    l.callbacks.afterNodeRemoved(h)
                }
            }
            l.head.afterHeadMorphed(t, {
                added: r,
                kept: o,
                removed: i
            });
            return f
        }
        function p() {}
        function i() {}
        function s(e, t, n) {
            return {
                target: e,
                newContent: t,
                config: n,
                morphStyle: n.morphStyle,
                ignoreActive: n.ignoreActive,
                idMap: E(e, t),
                deadIds: new Set,
                callbacks: Object.assign({
                    beforeNodeAdded: i,
                    afterNodeAdded: i,
                    beforeNodeMorphed: i,
                    afterNodeMorphed: i,
                    beforeNodeRemoved: i,
                    afterNodeRemoved: i
                }, n.callbacks),
                head: Object.assign({
                    style: "merge",
                    shouldPreserve: function(e) {
                        return e.getAttribute("im-preserve") === "true"
                    },
                    shouldReAppend: function(e) {
                        return e.getAttribute("im-re-append") === "true"
                    },
                    shouldRemove: i,
                    afterHeadMorphed: i
                }, n.head)
            }
        }
        function c(e, t, n) {
            if (e == null || t == null) {
                return false
            }
            if (e.nodeType === t.nodeType && e.tagName === t.tagName) {
                if (e.id !== "" && e.id === t.id) {
                    return true
                } else {
                    return x(n, e, t) > 0
                }
            }
            return false
        }
        function h(e, t) {
            if (e == null || t == null) {
                return false
            }
            return e.nodeType === t.nodeType && e.tagName === t.tagName
        }
        function m(t, e, n) {
            while (t !== e) {
                let e = t;
                t = t.nextSibling;
                N(e, n)
            }
            T(n, e);
            return e.nextSibling
        }
        function b(n, e, l, r, i) {
            let o = x(i, l, e);
            let t = null;
            if (o > 0) {
                let e = r;
                let t = 0;
                while (e != null) {
                    if (c(l, e, i)) {
                        return e
                    }
                    t += x(i, e, n);
                    if (t > o) {
                        return null
                    }
                    e = e.nextSibling
                }
            }
            return t
        }
        function g(e, t, n, l, r) {
            let i = l;
            let o = n.nextSibling;
            let d = 0;
            while (i != null) {
                if (x(r, i, e) > 0) {
                    return null
                }
                if (h(n, i)) {
                    return i
                }
                if (h(o, i)) {
                    d++;
                    o = o.nextSibling;
                    if (d >= 2) {
                        return null
                    }
                }
                i = i.nextSibling
            }
            return i
        }
        function v(n) {
            let l = new DOMParser;
            let e = n.replace(/<svg(\s[^>]*>|>)([\s\S]*?)<\/svg>/gim, "");
            if (e.match(/<\/html>/) || e.match(/<\/head>/) || e.match(/<\/body>/)) {
                let t = l.parseFromString(n, "text/html");
                if (e.match(/<\/html>/)) {
                    t.generatedByIdiomorph = true;
                    return t
                } else {
                    let e = t.firstChild;
                    if (e) {
                        e.generatedByIdiomorph = true;
                        return e
                    } else {
                        return null
                    }
                }
            } else {
                let e = l.parseFromString("<body><template>" + n + "</template></body>", "text/html");
                let t = e.body.querySelector("template").content;
                t.generatedByIdiomorph = true;
                return t
            }
        }
        function S(e) {
            if (e == null) {
                const t = document.createElement("div");
                return t
            } else if (e.generatedByIdiomorph) {
                return e
            } else if (e instanceof Node) {
                const t = document.createElement("div");
                t.append(e);
                return t
            } else {
                const t = document.createElement("div");
                for (const n of [...e]) {
                    t.append(n)
                }
                return t
            }
        }
        function y(e, t, n) {
            let l = [];
            let r = [];
            while (e != null) {
                l.push(e);
                e = e.previousSibling
            }
            while (l.length > 0) {
                let e = l.pop();
                r.push(e);
                t.parentElement.insertBefore(e, t)
            }
            r.push(t);
            while (n != null) {
                l.push(n);
                r.push(n);
                n = n.nextSibling
            }
            while (l.length > 0) {
                t.parentElement.insertBefore(l.pop(), t.nextSibling)
            }
            return r
        }
        function A(e, t, n) {
            let l;
            l = e.firstChild;
            let r = l;
            let i = 0;
            while (l) {
                let e = M(l, t, n);
                if (e > i) {
                    r = l;
                    i = e
                }
                l = l.nextSibling
            }
            return r
        }
        function M(e, t, n) {
            if (h(e, t)) {
                return .5 + x(n, e, t)
            }
            return 0
        }
        function N(e, t) {
            T(t, e);
            t.callbacks.beforeNodeRemoved(e);
            e.remove();
            t.callbacks.afterNodeRemoved(e)
        }
        function k(e, t) {
            return !e.deadIds.has(t)
        }
        function w(e, t, n) {
            let l = e.idMap.get(n) || o;
            return l.has(t)
        }
        function T(e, t) {
            let n = e.idMap.get(t) || o;
            for (const l of n) {
                e.deadIds.add(l)
            }
        }
        function x(e, t, n) {
            let l = e.idMap.get(t) || o;
            let r = 0;
            for (const i of l) {
                if (k(e, i) && w(e, i, n)) {
                    ++r
                }
            }
            return r
        }
        function H(e, n) {
            let l = e.parentElement;
            let t = e.querySelectorAll("[id]");
            for (const r of t) {
                let t = r;
                while (t !== l && t != null) {
                    let e = n.get(t);
                    if (e == null) {
                        e = new Set;
                        n.set(t, e)
                    }
                    e.add(r.id);
                    t = t.parentElement
                }
            }
        }
        function E(e, t) {
            let n = new Map;
            H(e, n);
            H(t, n);
            return n
        }
        return {
            morph: e
        }
    }()
});
htmx.defineExtension("morph", {
    isInlineSwap: function(e) {
        return e === "morph"
    },
    handleSwap: function(e, t, n) {
        if (e === "morph" || e === "morph:outerHTML") {
            return Idiomorph.morph(t, n.children)
        } else if (e === "morph:innerHTML") {
            return Idiomorph.morph(t, n.children, {
                morphStyle: "innerHTML"
            })
        }
    }
});
