<div id="login" class="shadow sm:rounded-md sm:overflow-hidden">
    <div x-data="{remember: <?= old('allowRemember', setting('Auth.sessionConfig')['allowRemembering']) ? 1 : 0 ?>}" class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <h6 class="text-slate-400 text-sm mt-5 mb-6 font-bold uppercase">Login</h6>

        <div class="relative w-full mb-3">
            <div class="col-12 col-sm-4">
                <div class="form-check">
                    <input class="form-check-input form-checkbox border-0 rounded text-blueGray-700 ml-1 w-5 h-5 ease-linear bg-gray-300 transition-all duration-150" type="checkbox" name="allowRemember" value="1" id="allow-remember" <?php if (old('allowRemember', setting('Auth.sessionConfig')['allowRemembering'])) : ?> checked <?php endif ?> x-on:click="remember = ! remember">
                    <label class="form-check-label" for="allow-remember">
                        Allow users to be "remembered"
                    </label>
                </div>
            </div>
            <div class="col px-5">
                <p class="text-muted small text-sm text-gray-500">This makes it so users do not have to login every visit.</p>
            </div>
        </div>
        <div class="row mb-3" x-show="remember">
            <div class="form-group col-12 col-sm-4">
                <label for="rememberLength" class="form-label">Remember Users for how long?</label>
                <select name="rememberLength" class="border-0 px-3 py-3 placeholder-gray-300 bg-gray-300 text-gray-600 rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                    <option value="0">How long to remember...</option>
                    <?php if (isset($rememberOptions) && count($rememberOptions)) : ?>
                        <?php foreach ($rememberOptions as $title => $seconds) : ?>
                            <option value="<?= $seconds ?>" <?php if (old('rememberLength', setting('Auth.sessionConfig')['rememberLength']) === (string) $seconds) : ?> selected <?php endif ?>>
                                <?= $title ?>
                            </option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
        </div>

        <div class="relative w-full mb-3">
            <div class="col-12 col-sm-4">
                <div class="form-check">
                    <input class="form-check-input form-checkbox border-0 rounded text-blueGray-700 ml-1 w-5 h-5 ease-linear bg-gray-300 transition-all duration-150" type="checkbox" name="email2FA" value="CodeIgniter\Shield\Authentication\Actions\Email2FA" id="email-2fa" <?php if (old('email2FA', setting('Auth.actions')['login']) === 'CodeIgniter\Shield\Authentication\Actions\Email2FA') : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="email-2fa">
                        Force 2FA check after login?
                    </label>
                </div>
            </div>
            <div class="col px-5">
                <p class="text-muted small text-sm text-gray-500">If checked, will send a code via email for them to confirm.</p>
            </div>
        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" />
    </div>

</div>