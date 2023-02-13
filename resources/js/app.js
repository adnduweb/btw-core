//This is you main entry file, Be creative =)

import "../css/app.css"

import 'htmx.org';

import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
Alpine.plugin(persist)

window.Alpine = Alpine;

let timer;

//Prefix alpine special attributes to pass W3C validation
document.addEventListener('alpine:init', () => {

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
            }, 2000 * totalVisible)
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
    }))
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


