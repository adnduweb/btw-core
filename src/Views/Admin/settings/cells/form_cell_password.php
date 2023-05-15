<div id="password" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.cellh3.passwords'); ?></h3>

        <!-- Site Name -->
        <div class="row">

        <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                'type' => 'number',
                'label' => lang('Form.settings.minimumPasswordLength'),
                'name' => 'minimumPasswordLength',
                'value' => old('minimumPasswordLength', setting('Auth.minimumPasswordLength')) ,
                'min' => "8", 
                'step' => "1",
                'description' => lang('Form.settings.AMinimumValueIsRecommended')
            ]); ?>

        </div>


        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.cellh3.PasswordValidators'); ?></h3>
        <p class="text-muted dark:text-gray-300"><?= lang('Form.settings.TheseRulesDetermineHowSecurePassword'); ?></p>

        <div class="relative w-full mb-3">
            <!-- Password Validators -->
            <div class="form-group col-6 col-sm-4">

                <!-- Composition Validator -->
                <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [ 'label' => lang('Form.settings.CompositionValidator'), 'name' => 'validators', 'value' => 'CodeIgniter\Shield\Authentication\Passwords\CompositionValidator' ,'checked' => (in_array('CodeIgniter\Shield\Authentication\Passwords\CompositionValidator', old('validators', setting('Auth.passwordValidators')), true)),'class' => "mb-3"]); ?>
                <!-- Nothing Personal Validator -->
                <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [ 'label' => lang('Form.settings.NothingPersonalValidator'), 'name' => 'validators', 'value' => 'CodeIgniter\Shield\Authentication\Passwords\NothingPersonalValidator' ,'checked' => (in_array('CodeIgniter\Shield\Authentication\Passwords\NothingPersonalValidator', old('validators', setting('Auth.passwordValidators')), true)),'class' => "mb-3"]); ?>
                <!-- Dictionary Validator -->
                <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [ 'label' => lang('Form.settings.NothingCompositionValidator'), 'name' => 'validators', 'value' => 'CodeIgniter\Shield\Authentication\Passwords\DictionaryValidator' ,'checked' => (in_array('CodeIgniter\Shield\Authentication\Passwords\DictionaryValidator', old('validators', setting('Auth.passwordValidators')), true)),'class' => "mb-3"]); ?>
                 <!-- Pwned Validator -->
                 <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [ 'label' => lang('Form.settings.DictionaryValidator'), 'name' => 'validators', 'value' => 'CodeIgniter\Shield\Authentication\Passwords\PwnedValidator' ,'checked' => (in_array('CodeIgniter\Shield\Authentication\Passwords\PwnedValidator', old('validators', setting('Auth.passwordValidators')), true)),'class' => "mb-3"]); ?>
            </div>
            <div class="col-6 px-4">
                <ul class="text-muted small text-sm text-gray-500  dark:text-gray-300">
                    <li><?= lang('Form.settings.CompositionValidatorDesc'); ?>.</li>
                    <li><?= lang('Form.settings.NothingPersonalValidatorDesc'); ?>.</li>
                    <li><?= lang('Form.settings.NothingCompositionValidatorDesc'); ?>.</li>
                    <li><?= lang('Form.settings.PasswordsNote'); ?>.</li>
                </ul>
            </div>
        </div>

    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingpassword" />
    </div>

</div>