<div id="email" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Email</h3>



        <div class="row mb-3">

            <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                'type' => 'text',
                'label' => lang('Btw.Name'),
                'name' => 'fromName',
                'value' => old('fromName', setting('Email.fromName'))
            ]); ?>

        </div>

        <div class="row mb-3">

            <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                'type' => 'text',
                'label' => lang('Btw.fromEmail'),
                'name' => 'fromEmail',
                'value' => old('fromEmail', setting('Email.fromEmail'))
            ]); ?>

        </div>

        <p class="dark:text-gray-300">This specifies the default email address and name that will be used when sending an email.</p>

        <fieldset x-data="{openTab: '<?= $activeTab ?>'}">
            <legend class="dark:text-gray-300">Mail Settings</legend>

            <p class="dark:text-gray-300 mb-5">Select the protocol used when sending mail. The most common scenario is using SMTP.</p>

            <div class="row mb-3">
                <div class="form-group col-12 col-sm-6 col-md-3">

                    <?= view_cell('Btw\Core\Cells\SelectCell::renderList', [
                        'label' => lang('Btw.protocol'),
                        'name' => 'protocol',
                        'options' => ['smtp' => 'smtp', 'mail' => 'mail', 'sendmail' => 'sendmail'],
                        'selected' => (old('protocol', setting('Email.protocol'))),
                        'byKey' => true,
                        'hxGet' => "/" . ADMIN_AREA . "/settings/timezones",
                        'hxTarget' => "#timezone",
                        'hxInclude' => "[name='timezoneArea']",
                        'hxTrigger' => "change",
                        'change' => "openTab=event.target.value"
                    ]); ?>

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

                        <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                            'type' => 'text',
                            'label' => lang('Btw.mailPath'),
                            'name' => 'mailPath',
                            'value' => old('mailPath', setting('Email.mailPath'))
                        ]); ?>

                    </div>
                </div>

                <!-- SMTP Settings -->
                <div id="mail-settings" x-show="openTab === 'smtp'" x-transition>
                    <!-- Host -->
                    <div class="row mb-3" x-data="{open: 0}">

                        <div class="form-group col-12 col-sm-6">

                            <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                                'type' => 'text',
                                'label' => lang('Btw.SMTPHost'),
                                'name' => 'SMTPHost',
                                'value' => old('SMTPHost', setting('Email.SMTPHost'))
                            ]); ?>

                        </div>
                        <!-- Port -->
                        <div class="form-group col-12 col-sm-3">

                            <?= view_cell('Btw\Core\Cells\SelectCell::renderList', [
                                'label' => lang('Btw.SMTPPort'),
                                'name' => 'protocol',
                                'options' =>  ['25' => '25', '587' => '587', '465' => '465',  '2525' => '2525',  'other' => 'other'],
                                'selected' => (old('SMTPPort', setting('Email.SMTPPort'))),
                                'alpinejs' => ['@click="open = false"', '@click="open = false"', '@click="open = false"',  '@click="open = false"',  '@click="open = true"'],
                                'change' => "openTab=event.target.value"
                            ]); ?>

                        </div>
                        <!-- Custom Port -->

                        <div class="form-group col-12 col-sm-3" x-show="open">

                            <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                                'type' => 'text',
                                'label' => lang('Btw.Other'),
                                'name' => 'SMTPPortOther',
                                'value' => old('SMTPPortOther', setting('Email.SMTPPortOther'))
                            ]); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Username -->
                        <div class="form-group col-12 col-sm-6">

                            <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                                'type' => 'text',
                                'label' => lang('Btw.Username'),
                                'name' => 'SMTPUser',
                                'value' => old('SMTPUser', setting('Email.SMTPUser'))
                            ]); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Password -->
                        <div class="form-group col-12 col-sm-6">

                            <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                                'type' => 'text',
                                'label' => lang('Btw.Password'),
                                'name' => 'SMTPPass',
                                'value' => old('SMTPPass', setting('Email.SMTPPass'))
                            ]); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Crypto -->
                        <div class="form-group col-12 col-sm-6">

                            <?= view_cell('Btw\Core\Cells\SelectCell::renderList', [
                                'label' => lang('Btw.SMTPCrypto'),
                                'name' => 'SMTPCrypto',
                                'options' =>  ['tls' => 'tls', 'ssl' => 'ssl'],
                                'selected' => (old('SMTPCrypto', setting('Email.SMTPCrypto')))
                            ]); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Timeout -->
                        <div class="form-group col-12 col-sm-3">

                            <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                                'type' => 'text',
                                'label' => lang('Btw.Timeout (in seconds)'),
                                'name' => 'SMTPTimeout',
                                'value' => old('SMTPTimeout', setting('Email.SMTPTimeout'))
                            ]); ?>

                        </div>

                        <!-- Timeout -->
                        <div class="form-group col-12 col-sm-3">

                            <?= view_cell('Btw\Core\Cells\SelectCell::renderList', [
                                'label' => lang('Btw.Persistant Connection?'),
                                'name' => 'SMTPKeepAlive',
                                'options' =>  ['0' => '0', '1' => '1'],
                                'selected' => (old('SMTPKeepAlive', setting('Email.SMTPCrypto')))
                            ]); ?>

                        </div>
                    </div>

                </div>
            </div>

        </fieldset>


    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadinggeneral" />
    </div>

</div>