<div id="email" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5  space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.cellh3.Email'); ?></h3>

        <?= validation_list_errors() ?>

        <div class="row mb-3">

            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'text',
                'label' => lang('Form.general.Name'),
                'name' => 'fromName',
                'required' => true,
                'value' => old('fromName', setting('Email.fromName'))
            ]); ?>

        </div>

        <div class="row mb-3">

            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'text',
                'label' => lang('Form.general.fromEmail'),
                'name' => 'fromEmail',
                'required' => true,
                'value' => old('fromEmail', setting('Email.fromEmail')),
                'description' => lang('Form.settings.ThisSpecifiesTheDefaultEmailAddressAndNnameThatWillBeUsedWhenSendingAnEmail'),
            ]); ?>

        </div>

        <fieldset x-data="{openTab: '<?= $activeTab ?>'}">
            <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.cellh3.MailSettings'); ?></h3>

            <p class="dark:text-gray-300 mb-5 text-sm text-gray-500"><?= lang('Form.settings.SelectTheProtocolUsedWhenSendingMailSMTP'); ?></p>

            <div class="row mb-3">
                <div class="form-group col-12 col-sm-6 col-md-3">

                    <?= view_cell('Btw\Core\Cells\Forms\SelectCell::renderList', [
                        'label' => lang('Form.general.protocol'),
                        'name' => 'protocol',
                        'options' => ['smtp' => 'smtp', 'mail' => 'mail', 'sendmail' => 'sendmail'],
                        'selected' => (old('protocol', setting('Email.protocol'))),
                        'byKey' => true,
                        'hxTrigger' => "change",
                        'change' => "openTab=event.target.value"
                    ]); ?>

                </div>
            </div>

            <div class="tab-content mx-5 mt-3">
                <!-- Mail Settings -->
                <div id="mail-settings" x-show="openTab === 'mail'" style="display: none;" x-transition>
                    <p class="alert alert-info dark:text-gray-300 text-sm text-gray-500"><?= lang('Form.settings.MailIsOnlyAvailableOnLinuxServers'); ?> </p>
                </div>

                <!-- SendMail Settings -->
                <div id="mail-settings" x-show="openTab === 'sendmail'" style="display: none;" x-transition>
                    <div class="row mb-3">

                        <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                            'type' => 'text',
                            'label' => lang('Form.general.mailPath'),
                            'name' => 'mailPath',
                            'value' => old('mailPath', setting('Email.mailPath'))
                        ]); ?>

                    </div>
                </div>

                <!-- SMTP Settings -->
                <div id="mail-settings" x-show="openTab === 'smtp'" style="display: none;" x-transition>
                    <!-- Host -->
                    <div class="row mb-3" x-data="{open: 0}">

                        <div class="form-group col-12 col-sm-6">

                            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                                'type' => 'text',
                                'label' => lang('Form.general.SMTPHost'),
                                'name' => 'SMTPHost',
                                'value' => old('SMTPHost', setting('Email.SMTPHost'))
                            ]); ?>

                        </div>
                        <!-- Port -->
                        <div class="form-group col-12 col-sm-3">

                            <?= view_cell('Btw\Core\Cells\Forms\SelectCell::renderList', [
                                'label' => lang('Form.general.SMTPPort'),
                                'name' => 'SMTPPort',
                                'options' =>  ['25' => '25', '587' => '587', '465' => '465',  '2525' => '2525',  'other' => 'other'],
                                'default' =>  '25',
                                'selected' => (old('SMTPPort', setting('Email.SMTPPort'))),
                                'alpinejs' => ['@click="open = false"', '@click="open = false"', '@click="open = false"',  '@click="open = false"',  '@click="open = true"'],
                                'change' => "openTab=event.target.value"
                            ]); ?>

                        </div>
                        <!-- Custom Port -->

                        <div class="form-group col-12 col-sm-3" x-show="open">

                            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                                'type' => 'text',
                                'label' => lang('Form.general.Other'),
                                'name' => 'SMTPPortOther',
                                'value' => old('SMTPPortOther', setting('Email.SMTPPortOther'))
                            ]); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Username -->
                        <div class="form-group col-12 col-sm-6">

                            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                                'type' => 'text',
                                'label' => lang('Form.general.Username'),
                                'name' => 'SMTPUser',
                                'value' => old('SMTPUser', setting('Email.SMTPUser'))
                            ]); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Password -->
                        <div class="form-group col-12 col-sm-6">

                            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                                'type' => 'text',
                                'label' => lang('Form.general.Password'),
                                'name' => 'SMTPPass',
                                'value' => old('SMTPPass', setting('Email.SMTPPass'))
                            ]); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Crypto -->
                        <div class="form-group col-12 col-sm-6">

                            <?= view_cell('Btw\Core\Cells\Forms\SelectCell::renderList', [
                                'label' => lang('Form.general.SMTPCrypto'),
                                'name' => 'SMTPCrypto',
                                'options' =>  ['tls' => 'tls', 'ssl' => 'ssl'],
                                'selected' => (old('SMTPCrypto', setting('Email.SMTPCrypto')))
                            ]); ?>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Timeout -->
                        <div class="form-group col-12 col-sm-3">

                            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                                'type' => 'text',
                                'label' => lang('Form.settings.Timeout (in seconds)'),
                                'name' => 'SMTPTimeout',
                                'value' => old('SMTPTimeout', setting('Email.SMTPTimeout'))
                            ]); ?>

                        </div>

                        <!-- Timeout -->
                        <div class="form-group col-12 col-sm-3">

                            <?= view_cell('Btw\Core\Cells\Forms\SelectCell::renderList', [
                                'label' => lang('Form.settings.Persistant Connection?'),
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
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loadingemail"]) ?>
    </div>

</div>