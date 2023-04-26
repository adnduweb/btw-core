<div x-show="$store.openmodal" x-on:keydown.escape.prevent.stop="$dispatch('closemodal');" role="dialog"
    aria-modal="true" class="fixed inset-0 overflow-y-auto">
    <!-- Overlay -->
    <div x-show="$store.openmodal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

    <!-- Panel -->
    <div x-show="$store.openmodal" x-transition x-on:click="open = false"
        class="relative flex min-h-screen items-center justify-center p-4">
        <div x-on:click.stop x-trap.noscroll.inert="open"
            class="relative w-full max-w-2xl overflow-y-auto rounded-xl bg-white p-12 shadow-lg">
            <!-- Title -->
            <h2 class="text-3xl font-bold" :id="$id('modal-title')">Confirm</h2>

            <!-- Content -->
            <p class="mt-2 text-gray-600">Votre session a expiré <span id="decompte"></span></p>

            <!-- Buttons -->
            <div class="mt-8 flex space-x-2">
                <button type="button" x-on:click="$dispatch('closemodal');" class="rounded-md border border-gray-200 bg-white px-5 py-2.5">Ok
                </button>

            </div>
        </div>
    </div>
</div>
</div>