<?php

/** Definition du text */
$type = (isset($type)) ? $type : 'text';
$labelNew = (isset($label)) ? str_replace(' ', '_', $label) : '';
$nameNew = (isset($name)) ? str_replace(' ', '_', $name) : '';

?>

<label for="<?= $nameNew; ?>" class="form-label"><?= $labelNew; ?></label>
<select name="<?= $nameNew; ?>" class="border-0 px-3 py-3 placeholder-gray-300 bg-gray-300 text-gray-600 rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
<?= $slot; ?>
</select>

<?php if (isset($description) && $description != "false") : ?>
    <p class="mt-2 text-sm text-gray-500">
        <?= $description; ?>
    </p>
<?php endif; ?>