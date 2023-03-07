<div id="email" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Email</h3>



        <div class="row mb-3">
            <x-label for="fromName" label="<?= lang('Btw.Name'); ?>" />
            <x-inputs.text name="fromName" value="<?= old('fromName', setting('Email.fromName')) ?>" description="false" />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('fromName'); ?>
                </div>
            <?php endif ?>
        </div>

        <div class="row mb-3">
            <x-label for="fromEmail" label="<?= lang('Btw.Email'); ?>" />
            <x-inputs.text name="fromEmail" value="<?= old('fromEmail', setting('Email.fromEmail')) ?>" description="false" />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('fromEmail'); ?>
                </div>
            <?php endif ?>
        </div>

        <p class="dark:text-gray-300">This specifies the default email address and name that will be used when sending an email.</p>

        <fieldset x-data="{openTab: '<?= $activeTab ?>'}">
            <legend  class="dark:text-gray-300">Mail Settings</legend>

            <p class="dark:text-gray-300 mb-5">Select the protocol used when sending mail. The most common scenario is using SMTP.</p>

            <div class="row mb-3">
                <div class="form-group col-12 col-sm-6 col-md-3">
                    <x-inputs.select label="<?= lang('Btw.protocol'); ?>" name="protocol" selected="<?= (old('protocol', setting('Email.protocol')))  ?>" change="openTab=event.target.value">
                        <?= view_cell('Btw\Core\Cells\Select::renderList', ['options' => ['smtp' => 'smtp', 'mail' => 'mail', 'sendmail' => 'sendmail'], 'selected' => (old('protocol', setting('Email.protocol')))]); ?>
                    </x-inputs.select>
                </div>
            </div>

            <div class="tab-content mx-5 mt-3">
                <!-- Mail Settings -->
                <div id="mail-settings" x-show="openTab === 'mail'" x-transition>
                    <p class="alert alert-info dark:text-gray-300">Mail is only available on Linux servers. There are no options.</p>
                </div>

                <!-- SendMail Settings -->
                <div id="mail-settings" x-show="openTab === 'sendmail'" x-transition>

                    <div class="row mb-3">

                        <x-label for="mailPath" label="<?= lang('Btw.Email'); ?>" />
                        <x-inputs.text name="mailPath" value="<?= old('mailPath', setting('Email.mailPath')) ?>" description="false" />
                        <?php if (isset($validation)) :  ?>
                            <div class="invalid-feedback block">
                                <?= $validation->getError('mailPath'); ?>
                            </div>
                        <?php endif ?>

                    </div>
                </div>

                <!-- SMTP Settings -->
                <div id="mail-settings" x-show="openTab === 'smtp'" x-transition>
                    <!-- Host -->
                    <div class="row mb-3" x-data="{open: 0}">

                        <div class="form-group col-12 col-sm-6">
                            <x-label for="SMTPHost" label="<?= lang('Btw.Email'); ?>" />
                            <x-inputs.text name="SMTPHost" value="<?= old('SMTPHost', setting('Email.SMTPHost')) ?>" description="false" />
                            <?php if (isset($validation)) :  ?>
                                <div class="invalid-feedback block">
                                    <?= $validation->getError('SMTPHost'); ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <!-- Port -->
                        <div class="form-group col-12 col-sm-3">
                            <x-inputs.select label="<?= lang('Btw.SMTPPort'); ?>" name="SMTPPort" selected="<?= (old('SMTPPort', setting('Email.SMTPPort')))  ?>" change="openTab=event.target.value">
                                <?= view_cell('Btw\Core\Cells\Select::renderList', [
                                    'options' => ['25' => '25', '587' => '587', '465' => '465',  '2525' => '2525',  'other' => 'other'],
                                    'alpinejs' => ['@click="open = false"', '@click="open = false"', '@click="open = false"',  '@click="open = false"',  '@click="open = true"'],
                                    'selected' => (old('SMTPPort', setting('Email.SMTPPort')))
                                ]); ?>
                            </x-inputs.select>
                            <?php if (isset($validation)) :  ?>
                                <div class="invalid-feedback block">
                                    <?= $validation->getError('SMTPPort'); ?>
                                </div>
                            <?php endif ?>

                        </div>
                        <!-- Custom Port -->

                        <div class="form-group col-12 col-sm-3" x-show="open">
                            <x-label for="SMTPPortOther" label="<?= lang('Btw.Other'); ?>" />
                            <x-inputs.text name="SMTPPortOther" value="<?= old('SMTPPortOther', setting('Email.SMTPHostOther')) ?>" description="false" />
                            <?php if (isset($validation)) :  ?>
                                <div class="invalid-feedback block">
                                    <?= $validation->getError('SMTPPortOther'); ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Username -->
                        <div class="form-group col-12 col-sm-6">
                            <x-label for="SMTPUser" label="<?= lang('Btw.Username'); ?>" />
                            <x-inputs.text name="SMTPUser" value="<?= old('SMTPUser', setting('Email.SMTPUser')) ?>" description="false" />
                            <?php if (isset($validation)) :  ?>
                                <div class="invalid-feedback block">
                                    <?= $validation->getError('SMTPUser'); ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Password -->
                        <div class="form-group col-12 col-sm-6">
                            <x-label for="SMTPPass" label="<?= lang('Btw.Password'); ?>" />
                            <x-inputs.text name="SMTPPass" value="<?= old('SMTPPass', setting('Email.SMTPPass')) ?>" description="false" />
                            <?php if (isset($validation)) :  ?>
                                <div class="invalid-feedback block">
                                    <?= $validation->getError('SMTPPass'); ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Crypto -->
                        <div class="form-group col-12 col-sm-6">
                            <x-inputs.select label="<?= lang('Btw.SMTPCrypto'); ?>" name="SMTPCrypto" selected="<?= (old('SMTPCrypto', setting('Email.SMTPCrypto')))  ?>">
                                <?= view_cell('Btw\Core\Cells\Select::renderList', [
                                    'options' => ['tls' => 'tls', 'ssl' => 'ssl'],
                                    'selected' => (old('SMTPCrypto', setting('Email.SMTPCrypto')))
                                ]); ?>
                            </x-inputs.select>
                            <?php if (isset($validation)) :  ?>
                                <div class="invalid-feedback block">
                                    <?= $validation->getError('SMTPPort'); ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Timeout -->
                        <div class="form-group col-12 col-sm-3">
                            <x-label for="SMTPTimeout" label="<?= lang('Btw.Timeout (in seconds)'); ?>" />
                            <x-inputs.text name="SMTPTimeout" value="<?= old('SMTPTimeout', setting('Email.SMTPTimeout')) ?>" description="false" />
                            <?php if (isset($validation)) :  ?>
                                <div class="invalid-feedback block">
                                    <?= $validation->getError('SMTPTimeout'); ?>
                                </div>
                            <?php endif ?>
                        </div>

                        <!-- Timeout -->
                        <div class="form-group col-12 col-sm-3">
                            <x-inputs.select label="<?= lang('Btw.Persistant Connection?'); ?>" name="SMTPKeepAlive" selected="<?= (old('SMTPKeepAlive', setting('Email.SMTPKeepAlive')))  ?>">
                                <?= view_cell('Btw\Core\Cells\Select::renderList', [
                                    'options' => ['0' => '0', '1' => '1'],
                                    'selected' => (old('SMTPKeepAlive', setting('Email.SMTPKeepAlive')))
                                ]); ?>
                            </x-inputs.select>
                            <?php if (isset($validation)) :  ?>
                                <div class="invalid-feedback block">
                                    <?= $validation->getError('SMTPPort'); ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>

                </div>
            </div>

        </fieldset>


    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 dark:bg-gray-700 ">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" loading="loadinggeneral" />
    </div>

</div>