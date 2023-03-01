<div id="password" class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <h6 class="text-slate-400 text-sm mt-5 mb-6 font-bold uppercase">Passwords</h6>

        <div class="relative w-full mb-3">
            <div class="form-group col-12 col-sm-4">
                <label for="minimumPasswordLength" class="form-label">Minimum Password Length</label>
                <input type="number" name="minimumPasswordLength" class="border-0 px-3 py-3 placeholder-gray-300 bg-gray-300 text-gray-600 rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" min="8" step="1" value="<?= old('minimumPasswordLength', setting('Auth.minimumPasswordLength')) ?>">
                <?php if (has_error('minimumPasswordLength')) : ?>
                    <p class="text-danger"><?= error('minimumPasswordLength') ?></p>
                <?php endif ?>
            </div>
            <div class="col px-5">
                <p class="text-muted small text-sm text-gray-500">A minimum value of 8 is suggested. 10 is recommended.</p>
            </div>
        </div>

        <br>

        <label for="passwordValidators" class="form-label">Password Validators</label>
        <p class="text-muted">These rules determine how secure a password must be.</p>

        <div class="relative w-full mb-3">
            <!-- Password Validators -->
            <div class="form-group col-6 col-sm-4">

                <!-- Composition Validator -->
                <div class="form-check">
                    <input class="form-check-input form-checkbox border-0 rounded bg-gray-300 text-gray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="checkbox" name="validators[]" value="CodeIgniter\Shield\Authentication\Passwords\CompositionValidator" <?php if (in_array(
                                                                                                                                                                                                                                                                            'CodeIgniter\Shield\Authentication\Passwords\CompositionValidator',
                                                                                                                                                                                                                                                                            old('validators', setting('Auth.passwordValidators')),
                                                                                                                                                                                                                                                                            true
                                                                                                                                                                                                                                                                        )) : ?> checked <?php endif ?>>
                    <label class="form-check-label">
                        Composition Validator
                    </label>
                </div>

                <!-- Nothing Personal Validator -->
                <div class="form-check">
                    <input class="form-check-input form-checkbox border-0 rounded bg-gray-300 text-gray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="checkbox" name="validators[]" value="CodeIgniter\Shield\Authentication\Passwords\NothingPersonalValidator" <?php if (in_array(
                                                                                                                                                                                                                                                                                'CodeIgniter\Shield\Authentication\Passwords\NothingPersonalValidator',
                                                                                                                                                                                                                                                                                old('validators', setting('Auth.passwordValidators')),
                                                                                                                                                                                                                                                                                true
                                                                                                                                                                                                                                                                            )) : ?> checked <?php endif ?>>
                    <label class="form-check-label">
                        Nothing Personal Validator
                    </label>
                </div>

                <!-- Dictionary Validator -->
                <div class="form-check">
                    <input class="form-check-input form-checkbox border-0 rounded bg-gray-300 text-gray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="checkbox" name="validators[]" value="CodeIgniter\Shield\Authentication\Passwords\DictionaryValidator" <?php if (in_array(
                                                                                                                                                                                                                                                                            'CodeIgniter\Shield\Authentication\Passwords\DictionaryValidator',
                                                                                                                                                                                                                                                                            old('validators', setting('Auth.passwordValidators')),
                                                                                                                                                                                                                                                                            true
                                                                                                                                                                                                                                                                        )) : ?> checked <?php endif ?>>
                    <label class="form-check-label">
                        Dictionary Validator
                    </label>
                </div>

                <!-- Pwned Validator -->
                <div class="form-check">
                    <input class="form-check-input form-checkbox border-0 rounded bg-gray-300 text-gray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="checkbox" name="validators[]" value="CodeIgniter\Shield\Authentication\Passwords\PwnedValidator" <?php if (in_array(
                                                                                                                                                                                                                                                                        'CodeIgniter\Shield\Authentication\Passwords\PwnedValidator',
                                                                                                                                                                                                                                                                        old('validators', setting('Auth.passwordValidators')),
                                                                                                                                                                                                                                                                        true
                                                                                                                                                                                                                                                                    )) : ?> checked <?php endif ?>>
                    <label class="form-check-label">
                        Pwned Validator
                    </label>
                </div>

                <p class="text-muted small mt-4">Note: Unchecking these will reduce the password security requirements.</p>
            </div>
            <div class="col-6 px-4">
                <ul class="text-muted small text-sm text-gray-500">
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
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" />
    </div>

</div>