<div id="general" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Général</h3>

        <?php ''; // print_r($userCurrent); 
        ?>
        <!-- Site Name -->
        <div class="flex flex-wrap -mx-3 mb-2">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.users.first_name'),
                    'name' => 'first_name',
                    'value' =>  old('first_name', $userCurrent->first_name)
                ]); ?>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.users.last_name'),
                    'name' => 'last_name',
                    'value' =>  old('last_name', $userCurrent->last_name)
                ]); ?>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">

                <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                    'type' => 'email',
                    'label' => lang('Form.users.email'),
                    'name' => 'email',
                    'value' =>  old('email', $userCurrent->email),
                    'description' => lang('Form.users.TheUsersWillHaveToRverifyTheirEmailAddress')
                ]); ?>

            </div>
        </div>


    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadinginformation" />
    </div>

</div>