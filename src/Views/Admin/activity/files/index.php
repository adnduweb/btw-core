<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Btw.Activity') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head> <?= lang('Btw.Activity'); ?> </x-page-head>

<x-admin-box collapse=true>
    <form action="<?= route_to('logs-files-delete-all'); ?>" method="post">
        <?= csrf_field() ?>

        <?php if (auth()->user()->can('logs.manage')) : ?>
            <div class="flex mb-3">
                <input type="submit" name="delete" id="delete-me" class="inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-red-600 text-white hover:bg-red-500 focus:border-red-700 focus:ring-red-200 active:bg-red-600 mr-3" value="<?= lang('Btw.delete_selected'); ?>" onclick="return confirm('<?= lang('Btw.delete_selected_confirm'); ?>')" />
                <input type="submit" value='<?= lang('Btw.delete_all'); ?>' name="delete_all" class="inline-flex items-center justify-center px-4 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-red-600 text-white hover:bg-red-500 focus:border-red-700 focus:ring-red-200 active:bg-red-600" onclick="return confirm('<?= lang('Btw.delete_all_confirm'); ?>')" />
            </div>
        <?php endif ?>

        <?= $this->include('Btw\Core\Views\Admin\activity\files\table'); ?>
    </form>
</x-admin-box>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    /**
     * Select All checkbox for data tables
     * using plain javascript
     */
    function toggleSelectAll(checkbox) {
        var table = checkbox.closest('table')
        var checkboxes = table.getElementsByTagName('input')

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = checkbox.checked
            }
        }
    }

    document.querySelector('.select-all').addEventListener('click', function(e) {
        toggleSelectAll(e.target)
    })
</script>
<?php $this->endSection() ?>