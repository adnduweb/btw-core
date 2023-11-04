<div id="general" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Général</h3>

        <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 ml-2 sm:col-span-4 md:mr-3">
            <!-- Photo File Input -->
            <input type="file" class="hidden" x-ref="photo" name="photo" x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
    ">




            <label class="block text-gray-700 text-sm font-bold mb-2 text-center" for="photo">
                Profile Photo <span class="text-red-600"> </span>
            </label>

            <div class="text-center">
                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="<?= service('storage')->getFileUrl($user->photo_profile, ['size' => 'image300x300']); ?>" class="w-40 h-40 m-auto rounded-full shadow" />
                </div>
                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block w-40 h-40 rounded-full m-auto shadow" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'" style="background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('null');">
                    </span>
                </div>
                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-800 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150 mt-2 ml-3" x-on:click.prevent="$refs.photo.click()">
                    <?= lang('Form.general.SelectNewPhoto'); ?>
                </button>
            </div>
        </div>


        <!-- Site Name -->
        <div class="flex flex-wrap -mx-3 mb-2">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.users.first_name'),
                    'name' => 'first_name',
                    'value' => old('first_name', $user->first_name)
                ]); ?>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.users.last_name'),
                    'name' => 'last_name',
                    'value' => old('last_name', $user->last_name)
                ]); ?>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'email',
                    'label' => lang('Form.users.email'),
                    'name' => 'email',
                    'value' => old('email', $user->email),
                    'description' => lang('Form.users.TheUsersWillHaveToRverifyTheirEmailAddress')
                ]); ?>

            </div>
        </div>

        <!-- Site Online? -->
        <div x-data="{ user_ban: <?= old('siteOnline', $user->isBanned()) ? 'true' : 'false' ?>}">
            <div class="w-full mb-6 md:mb-0">
                <?= view_cell('Btw\Core\Cells\Forms\SwitchCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.users.userban'),
                    'name' => 'userban',
                    'value' => '1',
                    'checked' => (old('userban', $user->isBanned() ?? false)),
                    'description' => lang('Form.users.userbanDesc'),
                    'xNotData' => "true",
                    'xOn' => "user_ban",
                    'xChange' => "user_ban = ! user_ban"
                ]); ?>
            </div>



            <div x-show="user_ban == true" class="w-full mt-6 mb-6 md:mb-0">
                <?php echo view_cell('Btw\Core\Cells\Forms\TextAreaCell::renderList', [
                    'label' => lang('Form.users.status_message'),
                    'name' =>  'status_message',
                    'value' => (old('status_message', $user->getBanMessage() ?? false)),
                    'description' => lang('Form.users.statusMessageDesc'),
                ]); ?>
            </div>
        </div>


    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loadinginformation"]) ?>
    </div>

</div>