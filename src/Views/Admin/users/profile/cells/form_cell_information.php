<div id="information" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">
            <?= lang('Btw.cellh3.general'); ?>
        </h3>

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
                    <img src="<?= service('storage')->getFileUrl(setting()->get('Users.photoProfile', 'user:' . user_id())); ?>" class="w-40 h-40 m-auto rounded-full shadow" />
                </div>
                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block w-40 h-40 rounded-full m-auto shadow" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'" style="background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('null');">
                    </span>
                </div>
                <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150 mt-2 ml-3" x-on:click.prevent="$refs.photo.click()">
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
                    'value' => old('first_name', $userCurrent->first_name)
                ]); ?>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.users.last_name'),
                    'name' => 'last_name',
                    'value' => old('last_name', $userCurrent->last_name)
                ]); ?>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-2">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'email',
                    'label' => lang('Form.users.email'),
                    'name' => 'email',
                    'value' => old('email', $userCurrent->email),
                    'description' => lang('Form.users.TheUsersWillHaveToRverifyTheirEmailAddress')
                ]); ?>
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.users.currency'),
                    'name' => 'currency',
                    'value' => old('currency', setting('Site.currency')),
                ]); ?>
            </div>
        </div>
    </div>

    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loadinginformation"]) ?>
    </div>
</div>