<?php

/** Definition du text */
$type = (isset($type)) ? $type : 'text';
$labelNew = (isset($label)) ? str_replace(' ', '_', $label) : '';
$nameNew = (isset($name)) ? str_replace(' ', '_', $name) : '';
$type = (isset($type)) ? $type : 'text';
$value = esc(set_value(str_replace(' ', '_', $name), $value ?? null), 'attr');
$min = (isset($min)) ? $min : '0';
$step = (isset($step)) ? $step : '1';

?>

<input type="<?= $type; ?>"<?php if ($type == 'number') : ?> min="<?= $min; ?>" step="<?= $step; ?>"<?php endif ?> name="<?= $nameNew ?>" id="<?= $labelNew; ?>" autocomplete="<?= $type; ?>" value="<?= $value ?>" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />

<?php if (has_error('siteName')) : ?>
    <p class="text-danger"><?= error((isset($name)) ? str_replace(' ', '_', $name) : '') ?></p>
<?php endif ?>

<?php if (isset($description) && $description != "false") : ?>
    <p class="mt-2 text-sm text-gray-500">
        <?= $description; ?>
    </p>
<?php endif; ?>