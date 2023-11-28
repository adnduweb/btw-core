import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus'
import persist from '@alpinejs/persist'
import intersect from '@alpinejs/intersect'
import anchor from '@alpinejs/anchor'
import navigate from './plugins/navigate'
import history from './plugins/history'
import morph from '@alpinejs/morph'
import mask from '@alpinejs/mask'
import Clipboard from "@ryangjchandler/alpine-clipboard"
import Alpine from 'alpinejs'
import { dispatch, toastHtmx } from './utils'

export function start() {
    dispatch(document, 'htmxwire:init')
    dispatch(document, 'htmxwire:initializing')
    toastHtmx();

    Alpine.plugin(morph)
    Alpine.plugin(history)
    Alpine.plugin(intersect)
    Alpine.plugin(collapse)
    Alpine.plugin(anchor)
    Alpine.plugin(focus)
    Alpine.plugin(persist)
    Alpine.plugin(navigate)
    Alpine.plugin(mask)
    Alpine.plugin(Clipboard.configure({
        onCopy: () => {
            console.log('Copied!')
        }
    }))

    Alpine.start()

    setTimeout(() => window.Htmxwire.initialRenderIsFinished = true)

    dispatch(document, 'htmxwire:initialized')
    dispatch(document, 'modalcomponent')
}

export function stop() {
    // @todo...
}

export function rescan() {
    // @todo...
}
