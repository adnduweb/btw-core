<div id="registration" class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">


        <div class="row mb-3">
            <x-inputs.checkbox  label="<?= lang('Btw.Allow users to register themselves on the site'); ?>" name="allowRegistration" checked="<?= (old('allowRegistration', setting('Auth.allowRegistration'))) ?>" description="If unchecked, an admin will need to create users." />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('allowRegistration'); ?>
                </div>
            <?php endif ?>
        </div>

        <div class="row mb-3">
            <x-inputs.checkbox  label="<?= lang('Btw.Force email verification after registration?'); ?>" name="emailActivation" value='CodeIgniter\Shield\Authentication\Actions\EmailActivator' checked="<?= (old('emailActivation', setting('Auth.actions')['register']) === 'CodeIgniter\Shield\Authentication\Actions\EmailActivator'); ?>" description="If checked, will send a code via email for them to confirm." />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('emailActivation'); ?>
                </div>
            <?php endif ?>
        </div>

        <?php if (isset($groups) && count($groups)) : ?>
            <!-- Default Group -->
            <div class="relative w-full mb-3">
                <div class="col-12 col-sm-4">

                    <label class="form-label mb-10">Default User Group:</label>

                    <?php foreach ($groups as $group => $info) : ?>
                        <div class="form-check ml-4 mb-2 mt-2 ">
                            <x-inputs.radio  label="<?= esc(ucfirst($info['title'])); ?>" name="defaultGroup" value="<?= $group ?>" checked="<?= ($group === $defaultGroup); ?>" description="false" />
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
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingregistration" />
    </div>

</div>