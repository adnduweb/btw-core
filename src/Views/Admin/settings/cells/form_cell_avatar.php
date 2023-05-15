<div id="avatar" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div x-data="{useGravatar: <?= old('useGravatar', setting('Users.useGravatar')) ? true : 'false' ?>}" class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Avatars</h3>


        <!-- Name Basis -->
        <div class="row mb-3">
            <div class="form-group col-12 col-sm-4">

                <?= view_cell('Btw\Core\Cells\SelectCell::renderList', [
                    'label' => lang('Form.settings.DisplayInitialsBasedOn'),
                    'name' => 'avatarNameBasis',
                    'options' => ['name' => 'Full Name', 'username' => 'Username'],
                    'selected' => old('avatarNameBasis', setting('Users.avatarNameBasis'))
                ]); ?>

            </div>
        </div>

        <!-- Use Gravatar -->
        <div class="row mb-3">

            <?= view_cell('Btw\Core\Cells\SwitchCell::renderList', [
                'label' => lang('Form.settings.UseGravatarForAvatars'),
                'name' => 'useGravatar',
                'value' => '1',
                'checked' => (old('useGravatar', setting('Users.useGravatar'))),
                'xNotData' => true,
                'xOn' => "useGravatar",
                'xChange' => "useGravatar = ! useGravatar",
            ]); ?>

        </div>


        <!-- Gravatar Default -->

        <div class="row mb-3" x-show="useGravatar != false">
            <div class="form-group col-12 col-sm-4">
                <?= view_cell('Btw\Core\Cells\SelectCell::renderList', [
                    'label' => lang('Form.settings.GravatarForDefaultStyle'),
                    'name' => 'gravatarDefault',
                    'options' => [
                        'mp' => 'mystery person',
                        'identicon' => 'identicon',
                        'identicon' => 'identicon',
                        'monsterid' => 'monsterid',
                        'wavatar' => 'wavatar',
                        'retro' => 'retro',
                        'robohash' => 'robohash',
                        'blank' => 'blank'
                    ],
                    'selected' => old('gravatarDefault', setting('Users.gravatarDefault'))
                ]); ?>
            </div>
        </div>


    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingavatar" />
    </div>

</div>