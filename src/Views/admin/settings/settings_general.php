<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>

<x-page-head>Settings </x-page-head>

<x-admin-box>

    <div class="flex">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\admin\settings\sidebar'); ?> 

        <div class="flex-1 ltr:pl-6 rtl:pr-6">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('general-post-settings'), [
                    'id' => 'kt_users_form_general', 'hx-post' => route_to('general-post-settings'), 'hx-target' => '#general',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadinggeneral",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="general" />
                <?= $this->include('Btw\Core\Views\admin\settings\cells\form_cell_general'); ?>
                <?= form_close(); ?>
            </div>


            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('general-post-settings'), [
                    'id' => 'kt_users_form_dateandtime', 'hx-post' => route_to('general-post-settings'), 'hx-target' => '#dateandtime',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc, event-header",  'novalidate' => false, 'data-loading-target' => "#loadingdateandtime",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="dateandtime" />
                <?= $this->include('Btw\Core\Views\admin\settings\cells\form_cell_dateandtime'); ?>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

</x-admin-box>
</div <?php $this->endSection() ?>