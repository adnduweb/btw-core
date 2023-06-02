<?php $identifiant = isset($row->uuid) ? $row->getUUIDIdentifier() : $row->getIdentifier();  ?>
<div class="form-check form-check-sm form-check-custom form-check-solid">
    <input class="form-check-input group-checkable w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" type="checkbox" data-identifier="<?= $identifiant; ?>" value="<?= $row->getIdentifier(); ?>" />
</div> 