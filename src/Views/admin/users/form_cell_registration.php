<div id="registration" class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

        <h6 class="text-slate-400 text-sm mt-5 mb-6 font-bold uppercase">Registration</h6>

        <div class="relative w-full mb-3">
            <div class="col-12 col-sm-4">
                <div class="form-check">
                    <input class="form-check-input form-checkbox border-0 rounded bg-gray-300 text-gray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="checkbox" name="allowRegistration" value="1" id="allow-registration" <?php if (old('allowRegistration', setting('Auth.allowRegistration'))) : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="allow-registration">
                        Allow users to register themselves on the site
                    </label>
                </div>
            </div>
            <div class="col px-5">
                <p class="text-muted small text-sm text-gray-500">If unchecked, an admin will need to create users.</p>
            </div>
        </div>

        <div class="relative w-full mb-3">
            <div class="col-12 col-sm-4">
                <div class="form-check">
                    <input class="form-check-input form-checkbox border-0 rounded bg-gray-300 text-gray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="checkbox" name="emailActivation" value='CodeIgniter\Shield\Authentication\Actions\EmailActivator' id="email-activation" <?php if (old('emailActivation', setting('Auth.actions')['register']) === 'CodeIgniter\Shield\Authentication\Actions\EmailActivator') : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="email-activation">
                        Force email verification after registration?
                    </label>
                </div>
            </div>
            <div class="col px-5">
                <p class="text-muted small text-sm text-gray-500">If checked, will send a code via email for them to confirm.</p>
            </div>
        </div>

        <?php if (isset($groups) && count($groups)) : ?>
            <!-- Default Group -->
            <div class="relative w-full mb-3">
                <div class="col-12 col-sm-4">

                    <label class="form-label mb-10">Default User Group:</label>

                    <?php foreach ($groups as $group => $info) : ?>
                        <div class="form-check ml-4 mb-2 ">
                            <input class="form-check-input form-checkbox border-0 rounded-3xl bg-gray-300 text-gray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="radio" name="defaultGroup" value="<?= $group ?>" <?php if ($group === $defaultGroup) : ?> checked <?php endif ?>>
                            <label class="form-check-label" for="defaultGroup">
                                <?= esc($info['title']) ?>
                            </label>
                        </div>
                    <?php endforeach ?>

                </div>
                <div class="col px-5 py-4">
                    <p class="text-muted small text-sm text-gray-500">The user group newly registered users are members of.</p>
                </div>
            </div>
        <?php endif ?>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingtest" />
    </div>

</div>