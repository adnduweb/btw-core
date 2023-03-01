<?php

function alert(string $type, string $message) {
    // return sprintf('<div hx-swap-oob="beforeend:#alerts-wrapper">
    //     <div _="on load wait 4 seconds then transition opacity to 0 then remove me" class="toast show mt-1" role="alert" aria-live="assertive" aria-atomic="true">
    //         <div class="toast-header">
    //             <span class="bg-%s avatar avatar-xs me-2"></span>
    //             <strong class="me-auto">CodeIgniter HTMX Demo</strong>
    //             <button class="btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
    //         </div>
    //         <div class="toast-body text-muted">%s</div>
    //     </div>
    // </div>', $type, $message);

//     return sprintf('
//     <div hx-swap-oob="beforeend:#alerts-wrapper">
//        <div _="on load wait 4 seconds then transition opacity to 0 then remove me" class="toast show mt-1" role="alert" aria-live="assertive" aria-atomic="true"
//     <div class="fixed inset-x-0 mx-auto bottom-5 overflow-hidden w-auto sm:w-full space-y-5 z-50">
// <div
//     x-transition:enter="transition ease-out duration-300 transform"
//     x-transition:enter-start="opacity-0"
//     x-transition:enter-end="opacity-100"
//     x-transition:leave="transition ease-in duration-300 transform"
//     x-transition:leave-start="opacity-100"
//     x-transition:leave-end="opacity-0"
//     class="relative bg-gray-700 text-white p-4 rounded-md overflow-hidden"
// >
//     <p
//         x-text="message.content"
//         class="text-sm"
//     >%s</p>
//     <button
//         @click="remove(message)"
//         class="absolute top-0 right-0 bg-gray-500/75 hover:bg-gray-400/50 p-1 rounded-bl-md text-sm transition"
//     >
//         <span class="sr-only">Dismiss</span>
//         <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
// <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
// </svg>            </button>
// </div> </div> </div> </div>', $type, $message);

    return sprintf('<div hx-swap-oob="beforeend:#alerts-wrapper">
        <div _="on load wait 4 seconds then transition opacity to 0 then remove me" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div x-show="show" x-data="{show: true}" class="relative inset-x-0 mx-auto bottom-5 overflow-hidden max-w-xl sm:w-full space-y-5 z-50">

        <div x-transition:enter="transition ease-in duration-200" x-transition:enter-start="transform opacity-0 translate-y-2" x-transition:enter-end="transform opacity-100" x-transition:leave="transition ease-out duration-500" x-transition:leave-start="transform opacity-100" x-transition:leave-end="transform  opacity-0" 
        class="bg-gray-900 bg-gradient-to-r dark:bg-gray-600 text-white p-3 rounded mb-3 shadow-lg flex justify-between items-center" style="pointer-events:all">
        
            <div class="col-start-1 col-span-3">
                <div class="text-white text-right">
                    <span>%s</span>
                </div>
            </div>
            <button x-on:click="show = false" class="btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"> X </button>
        </div>
        </div>
        </div>
    </div>', $message);

}




