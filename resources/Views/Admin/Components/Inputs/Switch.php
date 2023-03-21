<?php

/** Definition du text */
$labelNew = (isset($label)) ? $label : '';
$nameNew = (isset($name)) ? str_replace(' ', '_', $name) : '';
$value = (!empty($value)) ? $value : true;
$checkedNew = empty($checked) ? "false" : "true";
$xOnClick = (isset($xOnClick)) ? 'x-on:click="'.$xOnClick.'"' : false;
$xChange = (isset($xChange)) ? '@change="'.$xChange.'"' : false;
$xInput = (isset($xInput)) ? '@input="' . $xInput . '"' : '';
$class = (isset($class)) ? $class : '';
$xOn = (isset($xOn)) ? $xOn : 'on';
$xNotData = (isset($xNotData)) ? '' : 'x-data="{' . $xOn . ': ' . $checkedNew . '}"';


?>


<div class="flex items-center <?= $class; ?>">
    <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-slate-600 focus:ring-offset-2 bg-slate-400" <?= $xNotData; ?>  role="switch" aria-checked="true" :aria-checked="<?= $xOn; ?>.toString()" @click="<?= $xOn; ?> = !<?= $xOn; ?>" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-slate-400': <?= $xOn; ?>, 'bg-gray-200': !(<?= $xOn; ?>) }" <?= $xOnClick; ?> <?= $xChange; ?> >
        <span class="sr-only">Use setting</span>
        <input type="checkbox" id="toggle" name="<?= $nameNew; ?>" x-model="<?= $xOn; ?>" value="<?= $value; ?>" class="hidden appearance-none w-full h-full active:outline-none focus:outline-none" />
        <span class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-5" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': <?= $xOn; ?>, 'translate-x-0': !(<?= $xOn; ?>) }">
            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-0 duration-100 ease-out" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'opacity-0 duration-100 ease-out': <?= $xOn; ?>, 'opacity-100 duration-200 ease-in': !(<?= $xOn; ?>) }">
                <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                    <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-100 duration-200 ease-in" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'opacity-100 duration-200 ease-in': <?= $xOn; ?>, 'opacity-0 duration-100 ease-out': !(<?= $xOn; ?>) }">
                <svg class="h-3 w-3 text-slate-600" fill="currentColor" viewBox="0 0 12 12">
                    <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"></path>
                </svg>
            </span>
        </span>
    </button>

    <!-- Label -->
    <label @click="$refs.toggle.click(); $refs.toggle.focus()" :id="$id('toggle-label')" class="text-gray-900 font-medium ml-3">
        <?= $labelNew; ?>
    </label>
</div>

<?php if (isset($description) && $description != "false") : ?>
    <p class="mt-2 text-sm text-gray-500">
        <?= $description; ?>
    </p>
<?php endif; ?>