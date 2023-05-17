<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>

<x-page-head> <?= lang('Btw.general.editProfile'); ?> </x-page-head>

<x-admin-box>

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
    <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\sidebar'); ?>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('user-two-factor'), [
                    'id' => 'kt_users_form_two_factor', 'hx-post' => route_to('user-two-factor'), 'hx-target' => '#twofactor', 'hx-ext' => "loading-states, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadingtwofactor",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= '' //csrf_field() ?>
                <input type="hidden" name="section" value="two_factor" />
                <?= $this->include('Btw\Core\Views\Admin\users\profile\cells\form_cell_two_factor'); ?>
                <?= form_close(); ?>
            </div>

        </div>
    </div>

</x-admin-box>
<?php $this->endSection() ?>