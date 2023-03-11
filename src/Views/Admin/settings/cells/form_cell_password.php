<div id="password" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Passwords</h3>

        <!-- Site Name -->
        <div class="row">
            <x-label for="minimumPasswordLength" label="<?= lang('Btw.minimumPasswordLength'); ?>" />
            <x-inputs.text type="number" name="minimumPasswordLength" min="8" step="1" value="<?= old('minimumPasswordLength', setting('Auth.minimumPasswordLength'))  ?>" description="A minimum value of 8 is suggested. 10 is recommended." />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('minimumPasswordLength'); ?>
                </div>
            <?php endif ?>
        </div>


        <label for="passwordValidators" class="form-label dark:text-gray-300">Password Validators</label>
        <p class="text-muted dark:text-gray-300">These rules determine how secure a password must be.</p>

        <div class="relative w-full mb-3">
            <!-- Password Validators -->
            <div class="form-group col-6 col-sm-4">

                <!-- Composition Validator -->
                <x-inputs.switch label="<?= lang('Btw.Composition Validator'); ?>" name="validators" value="CodeIgniter\Shield\Authentication\Passwords\CompositionValidator" checked="<?= (in_array('CodeIgniter\Shield\Authentication\Passwords\CompositionValidator', old('validators', setting('Auth.passwordValidators')), true)) ?>" class="mb-3" description="false" />     
                <!-- Nothing Personal Validator -->
                <x-inputs.switch label="<?= lang('Btw.Nothing Personal Validator'); ?>" name="validators" value="CodeIgniter\Shield\Authentication\Passwords\NothingPersonalValidator" checked="<?= (in_array('CodeIgniter\Shield\Authentication\Passwords\NothingPersonalValidator', old('validators', setting('Auth.passwordValidators')), true)) ?>" class="mb-3" description="false" />
                <!-- Dictionary Validator -->
                <x-inputs.switch label="<?= lang('Btw.Composition Validator'); ?>" name="validators" value="CodeIgniter\Shield\Authentication\Passwords\DictionaryValidator" checked="<?= (in_array('CodeIgniter\Shield\Authentication\Passwords\DictionaryValidator', old('validators', setting('Auth.passwordValidators')), true)) ?>" class="mb-3" description="false" />
                 <!-- Pwned Validator -->
                 <x-inputs.switch label="<?= lang('Btw.Dictionary Validator'); ?>" name="validators" value="CodeIgniter\Shield\Authentication\Passwords\PwnedValidator" checked="<?= (in_array('CodeIgniter\Shield\Authentication\Passwords\PwnedValidator', old('validators', setting('Auth.passwordValidators')), true)) ?>" class="mb-3" description="false" />
            </div>
            <div class="col-6 px-4">
                <ul class="text-muted small text-sm text-gray-500  dark:text-gray-300">
                    <li>Composition Validator primarily checks the password length requirements.</li>
                    <li>Nothing Personal Validator checks the password for similarities between the password,
                        the email, username, and other personal fields to ensure they are not too similar and easy to guess.</li>
                    <li>Dictionary Validator checks the password against nearly 600,000 leaked passwords.</li>
                    <li>Pwned Validator uses a <a href="https://haveibeenpwned.com/Passwords" target="_blank">third-party site</a>
                        to check the password against millions of leaked passwords.</li>
                    <li>NOTE: You only need to select only one of Dictionary and Pwned Validators.</li>
                </ul>
            </div>
        </div>

    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 dark:bg-gray-700 ">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingpassword" />
    </div>

</div>