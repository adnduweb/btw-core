<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>
<x-page-head>
    <x-module-title><i class="fas fa-user"></i> Permissions</x-module-title>
</x-page-head>

<x-admin-box>

    <div class="row justify-content-md-center">

        <div class="col-sm-12 col-lg-8">
            <?= $this->include('Btw\Core\Views\admin\permissions\table'); ?>
        </div>

    </div>

    <div class="mx-auto w-full bg-gray-100 flex items-center justify-center h-screen" x-data="{ 'showModal': false }" @keydown.escape="showModal = false" x-cloak>


        <button type="button" x-data="{}" x-on:click="window.livewire.emitTo('welcome-modal', 'show')" class="inline-flex content-end px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
            </span>Click to Open Modal
        </button>


        <div x-data="{ show: @entangle($attributes->wire('model')).defer }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 overflow-y-auto px-4 py-6 md:py-24 sm:px-0 z-40">
            <div class="fixed inset-0 transform" x-on:click="show = false">
                <div x-show="show" class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div x-show="show" class="bg-white rounded-lg overflow-hidden transform sm:w-full sm:mx-auto sm:mx-auto
        max-w-lg">
                {{ $slot }}
            </div>
        </div>
    </div>



</x-admin-box>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>

</script>
<?php $this->endSection() ?>