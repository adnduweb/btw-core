<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Btw.Tokens') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head>
    <h2>Tokens</h2>
</x-page-head>

<x-admin-box>

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\sidebar'); ?>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states>
                <?= form_open(route_to('users-tokens'), [
                    'id' => 'kt_users_form_tokens', 'hx-post' => route_to('users-tokens'), 'hx-target' => '#tokens',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states, debug, json-enc",  'novalidate' => false, 'data-loading-target' => "#loadingtokens",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="tokens" />
                <?= $this->include('Btw\Core\Views\Admin\tools\tokens\cells\form_cell_manage'); ?>
                <?= form_close(); ?>
            </div>

        </div>

</x-admin-box>
<?php $this->endSection() ?>