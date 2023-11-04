<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?= $this->section('title') ?><?= lang('Btw.tokencreate') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.general.tokens_create')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

    <div class="relative flex h-full gap-5 sm:h-[calc(100vh_-_150px)]">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\components\sidebar'); ?>

        <div class="panel panel-adn h-full flex-1 overflow-auto">
            <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
<?= $this->include('Btw\Core\Views\Admin\components\sidebar_action'); ?>
                <?= form_open(route_to('tokencreate-create'), [
                    'id' => 'kt_users_form_tokencreate', 'hx-post' => route_to('tokencreate-create'), 'hx-target' => '#tokencreate',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states",  'novalidate' => false, 'data-loading-target' => "#loadingtokencreate",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="tokencreate" />
                <?= $this->include('Btw\Core\Views\Admin\tools\tokens\cells\form_cell_create'); ?>
                <?= form_close(); ?>
            </div>

        </div>
    </div>
</div>
<?php $this->endSection() ?>