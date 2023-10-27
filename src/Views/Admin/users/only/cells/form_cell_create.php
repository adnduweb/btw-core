<div id="general" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">

    <div class=" bg-white dark:bg-gray-800 border-b border-gray-200 px-4 py-5 sm:px-6">
        <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-2">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Information
                </h3>
            </div>

            <div class="ml-4 mt-2 flex-shrink-0">
                <div class="flex items-center">
                    <?= view_cell('Btw\Core\Cells\Forms\SwitchCell::renderList', [
                        'type' => 'text',
                        'label' => lang('Btw.active'),
                        'name' => 'active',
                        'value' => '1',
                        'checked' => (old('active')),
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
 

    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <!-- Site Name -->
        <div class="flex flex-wrap -mx-3 mb-2">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.users.first_name'),
                    'name' => 'first_name',
                    'value' => old('first_name')
                ]); ?>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.users.last_name'),
                    'name' => 'last_name',
                    'value' => old('last_name')
                ]); ?>

            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-2">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.users.username'),
                    'name' => 'username',
                    'value' => old('username')
                ]); ?>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'email',
                    'label' => lang('Form.users.email'),
                    'name' => 'email',
                    'value' => old('email')
                ]); ?>

            </div>
        </div>





        <div x-data="{ show: true }" class="w-full relative mb-6">
            <div class="relative">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'password',
                    'label' => lang('Form.users.newPassword'),
                    'name' => 'new_password',
                    'value' => "",
                    'xType' => "show ? 'password' : 'text'",
                    'xModel' => "new_password"
                ]); ?>
            </div>

        </div>

        <div x-data="{ show: true }" class="w-full relative mb-6">
            <div class="w-full ">
                <div class="relative">
                    <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                        'type' => 'password',
                        'label' => lang('Form.users.confirmPassword'),
                        'name' => 'pass_confirm',
                        'value' => "",
                        'xType' => "show ? 'password' : 'text'",
                        'xModel' => "pass_confirm"
                    ]); ?>
                </div>
                <?php if (isset($validation)) : ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('pass_confirm'); ?>
                    </div>
                <?php endif ?>

            </div>
        </div>

        <div class="flex -mx-1">
            <template x-for="(v,i) in 5">
                <div class="w-1/5 px-1">
                    <div class="h-2 rounded-xl transition-colors" :class="i<passwordScore?(passwordScore<=2?'bg-red-400':(passwordScore<=4?'bg-yellow-400':'bg-green-500')):'bg-gray-200'">
                    </div>
                </div>
            </template>
        </div>
        <hr class="my-5 border border-gray-200">
        <div class="mb-2">
            <label class="block text-xs font-semibold text-gray-500 mb-2">
                <?= lang('Form.users.passwordLength'); ?>
            </label>
            <input class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-blue-500 transition-colors" placeholder="Length" type="number" min="6" max="30" step="1" x-model="charsLength" @input="generatePassword()" />
            <input class="w-full" type="range" x-model="charsLength" min="6" max="30" step="1" @input="generatePassword()">
        </div>
        <div class="flex -mx-2 mb-2">
            <div class="w-1/2 px-2">
                <?= view_cell('Btw\Core\Cells\Forms\CheckBoxCell::renderList', ['label' => lang('Form.users.LOWERCASE'), 'name' => 'charsLower', 'value' => "", 'checked' => true, 'disabled' => true, 'xInput' => "generatePassword()", 'class' => "align-middle"]); ?>
            </div>
            <div class="w-1/2 px-2">
                <?= view_cell('Btw\Core\Cells\Forms\CheckBoxCell::renderList', ['label' => lang('Form.users.UPPERCASE'), 'name' => 'charsUpper', 'value' => "", 'checked' => true, 'xInput' => "generatePassword()", 'class' => "align-middle"]); ?>
            </div>
        </div>
        <div class="flex -mx-2">
            <div class="w-1/2 px-2">
                <?= view_cell('Btw\Core\Cells\Forms\CheckBoxCell::renderList', ['label' => lang('Form.users.NUMBERS'), 'name' => 'charsNumeric', 'value' => "", 'checked' => true, 'xInput' => "generatePassword()", 'class' => "align-middle"]); ?>
            </div>
            <div class="w-1/2 px-2">
                <?= view_cell('Btw\Core\Cells\Forms\CheckBoxCell::renderList', ['label' => lang('Form.users.SYMBOLS'), 'name' => 'charsSymbols', 'value' => "", 'checked' => true, 'xInput' => "generatePassword()", 'class' => "align-middle"]); ?>
            </div>
        </div>





        <fieldset>
            <legend class="">
                <?= lang('Form.settings.DefaultUserGroup'); ?>
            </legend>
            <div class="-space-y-px rounded-md bg-white">
                <?php foreach ($groups as $group => $info) : ?>
                    <!-- Checked: "z-10 border-blue-200 bg-blue-50", Not Checked: "border-gray-200" -->
                    <label class="<?= ($group === array_key_first($groups)) ? 'rounded-tl-md' : '' ?> <?= ($group === array_key_last($groups)) ? 'rounded-bl-md' : '' ?> relative flex cursor-pointer border p-4 focus:outline-none">
                        <input class="mt-0.5 h-4 w-4 shrink-0 cursor-pointer text-blue-600 border-gray-300 focus:ring-blue-600" type="checkbox" name="currentGroup[]" value="<?= $group ?>" <?php if (isset($currentGroup[$group])) : ?> checked <?php endif ?> aria-labelledby="currentGroup-0-label" aria-describedby="currentGroup-0-description">
                        <span class="ml-3 flex flex-col">
                            <!-- Checked: "text-blue-900", Not Checked: "text-gray-900" -->
                            <span id="privacy-setting-0-label" class="block text-sm font-medium">
                                <?= esc($info['title']) ?>
                            </span>
                            <!-- Checked: "text-blue-700", Not Checked: "text-gray-500" -->
                            <span id="privacy-setting-0-description" class="block text-sm">
                                <?= esc($info['description']) ?>
                            </span>
                        </span>
                    </label>
                <?php endforeach ?>
            </div>
        </fieldset>

        <?php if (isset($validation)) : ?>
            <div class="invalid-feedback block text-red-600">
                <?= $validation->getError('currentGroup[]'); ?>
            </div>
        <?php endif ?>

    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loadinginformation"]) ?>
    </div>

</div