<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>

<x-page-head>User </x-page-head>

<x-admin-box>

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\sidebar'); ?>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('user-information'), [
                    'id' => 'kt_users_form_information', 'hx-post' => route_to('user-information'), 'hx-target' => '#general',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadinginformation",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="general" />
                <?= $this->include('Btw\Core\Views\Admin\users\current\cells\form_cell_information'); ?>
                <?= form_close(); ?>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2 mb-5">
                <?= $this->setVar('userCurrent', $userCurrent)->include('Btw\Core\Views\Admin\users\only\cells\form_cell_other_information'); ?>
            </div>

        </div>
    </div>
    
</x-admin-box>
<?php $this->endSection() ?>
