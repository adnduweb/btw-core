<?= $this->extend(config('Themes')->views['layout_admin']) ?>

<?php $this->section('main') ?>

<?= view_cell('Btw\Core\Cells\Core\AdminPageTitle', ['message' => lang('Btw.general.editProfile')]) ?>

<div class="flex-auto <?= isset($collapse) ? '' : ''; ?> ">

    <div class="relative flex h-full gap-5 sm:h-[calc(100vh_-_150px)]">
        <?= $this->setVar('menu', $menu)->include('Btw\Core\Views\Admin\components\sidebar'); ?>

        <div class="panel panel-adn h-full flex-1 overflow-auto">
            <div class="mt-5 md:mt-0 md:col-span-2" data-loading-states>
<?= $this->include('Btw\Core\Views\Admin\components\sidebar_action'); ?>
                <?= form_open_multipart(route_to('company-display'), [
                    'id' => 'kt_users_form_information',
                    'hx-post' => route_to('company-display'),
                    'hx-target' => '#company',
                    'hx-swap' => 'none',
                    'hx-ext' => "loading-states, event-header",
                    'novalidate' => false,
                    'data-loading-target' => "#loadingcompany",
                    'data-loading-class-remove' => "hidden"
                ]); ?>
                <?= '' //csrf_field()
?>
                <input type="hidden" name="section" value="company" />
                <?= $this->include('Btw\Core\Views\Admin\users\profile\cells\form_cell_company'); ?>
                <?= form_close(); ?>
            </div>

        </div>
    </div>

</div>
<?php $this->endSection() ?>