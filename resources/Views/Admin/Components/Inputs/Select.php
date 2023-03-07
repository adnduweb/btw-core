<?php

/** Definition du text */
$type = (isset($type)) ? $type : 'text';
$labelNew = (isset($label)) ? str_replace(' ', '_', $label) : '';
$nameNew = (isset($name)) ? str_replace(' ', '_', $name) : '';
$xOnClick = (isset($xOnClick)) ? 'x-on:click="'.$xOnClick.'"' : false;
$xChange = (isset($change)) ? '@change="'.$change.'"' : false;
$hxGet = (isset($hxGet)) ? 'hx-get="'.$hxGet.'"' : false;
$hxTarget = (isset($hxTarget)) ? 'hx-target="'.$hxTarget.'"' : false;
$hxInclude = (isset($hxInclude)) ? 'hx-include="'.$hxInclude.'"' : false;
$hxTrigger = (isset($hxTrigger)) ? 'hx-trigger="'.$hxTrigger.'"' : false;
$hxSwap = (isset($hxSwap)) ? 'hx-swap="'.$hxSwap.'"' : false;

?>

<label for="<?= $nameNew; ?>" class="block text-sm font-medium text-gray-700 mt-px pb-2 dark:text-gray-300"><?= $labelNew; ?></label>
<select name="<?= $nameNew; ?>" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500  dark:text-gray-200 dark:bg-gray-900 ease-linear transition-all duration-150" 
<?= $xOnClick; ?> <?= $xChange; ?> <?= $hxGet; ?> <?= $hxTarget; ?> <?= $hxInclude; ?> <?= $hxTrigger; ?> <?= $hxSwap; ?>>
<?= $slot; ?>
</select>

<?php if (isset($description) && $description != "false") : ?>
    <p class="mt-2 text-sm text-gray-500">
        <?= $description; ?>
    </p>
<?php endif; ?>