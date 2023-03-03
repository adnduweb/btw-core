<?php

/** Definition du text */
$type = (isset($type)) ? $type : 'text';
$labelNew = (isset($label)) ? str_replace(' ', '_', $label) : '';
$nameNew = (isset($name)) ? str_replace(' ', '_', $name) : '';
$type = (isset($type)) ? $type : 'text';
$value = (isset($value)) ? $value : 1;
$checkedNew = esc(set_value(str_replace(' ', '_', $name), $checked ?? null), 'attr');
$xOnClick = (isset($xOnClick)) ? 'x-on:click="'.$xOnClick.'"' : false;
$xChange = (isset($change)) ? '@change="'.$change.'"' : false;

$class = (isset($class)) ? $class : '';


?>

<div class="flex items-center <?= $class; ?>">
    <input name="<?= $nameNew ?>" id="<?= $labelNew; ?>" type="checkbox" class="checkbox checkbox-primary rounded ml-1 w-5 h-5 ease-linear transition-all duration-150 " value="<?= $value; ?>" <?php if ($checkedNew) : ?> checked <?php endif ?> <?= $xOnClick; ?> <?= $xChange; ?> >
    <label for="role-<?= $nameNew ?>" class="ml-3 block whitespace-nowrap text-sm font-medium text-gray-700"><?= $labelNew; ?></label>
</div>
<?php if (isset($description) && $description != "false") : ?>
    <p class="mt-2 text-sm text-gray-500">
        <?= $description; ?>
    </p>
<?php endif; ?>