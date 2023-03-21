<div id="general" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Général</h3>

        <?php ''; // print_r($userCurrent); 
        ?>
        <!-- Site Name -->
        <div class="flex flex-wrap -mx-3 mb-2">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <x-label for="email" label="<?= lang('Btw.first_name'); ?>" />
                <x-inputs.text name="first_name" value="<?= old('first_name', $userCurrent->first_name) ?>" description="false" />
                <?php if (isset($validation)) :  ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('first_name'); ?>
                    </div>
                <?php endif ?>
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <x-label for="last_name" label="<?= lang('Btw.last_name'); ?>" />
                <x-inputs.text name="last_name" value="<?= old('last_name', $userCurrent->last_name) ?>" description="false" />
                <?php if (isset($validation)) :  ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('last_name'); ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <x-label for="email" label="<?= lang('Btw.email'); ?>" />
                <x-inputs.text type="email" name="email" value="<?= old('email', $userCurrent->email) ?>" description="<?= lang('Btw.The users will have to re-verify their email address if you change it or you can do it manually'); ?>" />
                <?php if (isset($validation)) :  ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('email'); ?>
                    </div>
                <?php endif ?>
            </div>
        </div>


    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 dark:bg-gray-700 ">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" loading="loadinginformation" />
    </div>

</div>