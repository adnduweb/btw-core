<?php $identifiant = isset($row->uuid) ? $row->getIdentifierUUID() : $row->getIdentifier();  ?>
<select id="location" name="<?= $name; ?>" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" hx-get="<?= $hxGet; ?>" hx-indicator=".progress">
    <?php foreach ($select as $key => $value) : ?>
        <option <?= ($selected ==  $key ) ? 'selected' : ''; ?> value="<?= $key; ?>"><?= $value[$byKey]; ?></option>
    <?php endforeach; ?>
</select>