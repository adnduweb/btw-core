<?php

// function alertHtmx(string $type, string $message) {
//     return sprintf('<div hx-swap-oob="beforeend:#alerts-wrapper">
//         <div _="on load wait 4 seconds then transition opacity to 0 then remove me" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
//         <div x-show="show" x-data="{show: true}" class="relative inset-x-0 mx-auto bottom-0 overflow-hidden max-w-xl sm:w-full space-y-5 z-50">

//         <div x-transition:enter="transition ease-in duration-200" x-transition:enter-start="transform opacity-0 translate-y-2" x-transition:enter-end="transform opacity-100" x-transition:leave="transition ease-out duration-500" x-transition:leave-start="transform opacity-100" x-transition:leave-end="transform  opacity-0" 
//         class="bg-gray-900 bg-gradient-to-r dark:bg-gray-600 text-white p-3 rounded mb-1 shadow-lg flex justify-between items-center" style="pointer-events:all">

//             <div class="col-start-1 col-span-3">
//                 <div class="text-white text-right">
//                     <span>%s</span>
//                 </div>
//             </div>
//             <button x-on:click="show = false" class="btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"> X </button>
//         </div>
//         </div>
//         </div>
//     </div>', $message);

// }


function alertHtmx(string $type, string $message)
{
    return sprintf('<script type="module">
    document.dispatchEvent(
        new CustomEvent("notify", {
          detail: {
            content: \'%s\',
            type: \'%s\',
          },
          bubbles: true,
        })
      );
      </script>', $message, $type);
}
