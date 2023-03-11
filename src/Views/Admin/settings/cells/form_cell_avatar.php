<div id="avatar" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div x-data="{useGravatar: <?= old('useGravatar', setting('Users.useGravatar')) ? true : 'false' ?>}" class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Avatars</h3>


        <!-- Name Basis -->
        <div class="row mb-3">
            <div class="form-group col-12 col-sm-4">
                <x-inputs.select label="<?= lang('Btw.Display initials based on:'); ?>" name="avatarNameBasis">
                    <?= view_cell('Btw\Core\Cells\Select::renderList', ['options' => ['name' => 'Full Name', 'username' => 'Username'], 'selected' => old('avatarNameBasis', setting('Users.avatarNameBasis'))]); ?>
                </x-inputs.select>
            </div>
        </div>

        <!-- Use Gravatar -->
        <div class="row mb-3">
            <x-inputs.switch label="<?= lang('Btw.Use Gravatar for avatars'); ?>" name="useGravatar" value="1" checked="<?= (old('useGravatar', setting('Users.useGravatar'))) ?>" xNotData="true" xOn="useGravatar" xChange="useGravatar = ! useGravatar" description="false" />
           <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('useGravatar'); ?>
                </div>
            <?php endif ?>
        </div>


        <!-- Gravatar Default -->

        <div class="row mb-3" x-show="useGravatar != false">
            <div class="form-group col-12 col-sm-4">
                <x-inputs.select label="<?= lang('Btw.Gravatar for default style'); ?>" name="gravatarDefault">
                    <?= view_cell('Btw\Core\Cells\Select::renderList', [
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
                </x-inputs.select>
            </div>
        </div>


    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 dark:bg-gray-700 ">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingavatar" />
    </div>

</div>