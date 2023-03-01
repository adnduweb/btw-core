<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head tback='<?= lang('Btw.back', ['rôles']); ?>' lback=<?= route_to('groups-list'); ?>> <?= lang('Btw.roles'); ?> </x-page-head>
<x-admin-box>

    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
                <p class="mt-1 text-sm text-gray-600">
                    This information will be displayed publicly so be careful what you share.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <?= form_open(route_to('group-save'), [
                'id' => 'kt_groups_form', 'hx-post' => route_to('group-save'), 'hx-target' => '#allergy_target',  'hx-swap' => 'morph:outerHTML',  'hx-ext' => "loading-states",  'novalidate' => false, 'data-loading-target' => "#loading",
                'data-loading-class-remove' => "hidden"
            ]); ?>
            <input type="hidden" name="alias" value="<?= $alias; ?>" />
            <?= $this->setVar('group', $group)->include('Btw\Core\Views\admin\groups\form_cell'); ?>
            <?= form_close(); ?>
        </div>
    </div>



</x-admin-box>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>

</script>
<?php $this->endSection() ?>