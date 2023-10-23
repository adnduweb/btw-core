<div id="company" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
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
                    <img src="<?= !empty($company->logo) ? service('storage')->getFileUrl($company->logo) : ''; ?>" class="w-40 h-40 m-auto rounded-full shadow" />
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


        <div class="flex flex-wrap -mx-3 mb-4">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.address.lastname'),
                    'name' => 'lastname',
                    'value' => old('lastname', $company->lastname),
                    'lang' => false
                ]); ?>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.address.firstname'),
                    'name' => 'firstname',
                    'value' => old('firstname', $company->firstname),
                    'lang' => false
                ]); ?>

            </div>
        </div>

        <div class="w-full mb-6 md:mb-4">
            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'email',
                'label' => lang('Form.address.email'),
                'name' => 'email',
                'value' => old('email', $company->email),
                'lang' => false,
            ]); ?>
        </div>

        <div class="w-full mb-6 md:mb-4">
            <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                'type' => 'text',
                'label' => lang('Form.address.address1'),
                'name' => 'address1',
                'value' => old('address1', $company->address1),
                'lang' => false,
            ]); ?>
        </div>

        <div class="flex flex-wrap -mx-3 mb-4">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.address.postcode'),
                    'name' => 'postcode',
                    'value' => old('postcode', $company->postcode),
                    'lang' => false
                ]); ?>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.address.city'),
                    'name' => 'city',
                    'value' => old('city', $company->city),
                    'lang' => false
                ]); ?>

            </div>
        </div>

        <!-- Site Name -->
        <div class="flex flex-wrap -mx-3 mb-4">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

            <?= view_cell('Btw\Core\Cells\Forms\DropdownCell::renderList', [
                'label' => lang('Form.address.type_company'),
                'name' => 'type_company',
                'placeholder' => lang('Form.address.selectTypeCompany'),
                'options' => \Btw\Core\Libraries\Data::getCompagniesType(),
                'byKey' => true,
                'key' => "id",
                'val' => "nom_long",
                'required' => true,
                'default' => '1',
                'class' => "select2-type_company",
                'selected' => old('type_company', $company->type_company)
            ]); ?>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <?= view_cell('Btw\Core\Cells\Forms\DropdownCell::renderList', [
                    'label' => lang('Form.general.listCurrencies'),
                    'name' => 'currency_code',
                    'placeholder' => lang('Form.general.selectCurrencies'),
                    'options' => $currencies,
                    'key' => "id",
                    'val' => "nameoption",
                    'required' => true,
                    'class' => "select2-currency",
                    'byKey' => true,
                    'selected' =>  old('currency_code', $company->currency_code ?? null),
                ]); ?>
            </div>

        </div>

        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
            <div class="flex flex-col">
                <div class="flex flex-row items-center mb-2">
                    <?= theme()->getSVG('admin/images/icons/bonasavoir.svg', 'svg-icon flex-shrink-0 h-6 w-6 mr-2 dark:text-gray-200 text-gray-800 svg-white', true); ?>
                    <span class="font-bold"><?= lang('Btw.attention'); ?>!</span>
                </div>
                <?= lang('Btw.depaseTotalSeuilTVAME'); ?>
            </div> 
        </div>

        <div class="flex flex-wrap -mx-3 mb-4">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.address.company'),
                    'name' => 'company',
                    'value' => old('company', $company->company),
                    'lang' => false
                ]); ?>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.address.vat_number'),
                    'name' => 'vat_number',
                    'value' => old('vat_number', $company->vat_number),
                    'lang' => false
                ]); ?>

            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-4">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.address.siret'),
                    'name' => 'siret',
                    'value' => old('siret', $company->siret),
                    'lang' => false
                ]); ?>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'text',
                    'label' => lang('Form.address.ape'),
                    'name' => 'ape',
                    'value' => old('ape', $company->ape),
                    'lang' => false
                ]); ?>

            </div>
        </div>


        <!-- Site Name -->
        <div class="w-full mb-6 md:mb-4">

            <?= view_cell('Btw\Core\Cells\Forms\DropdownCell::renderList', [
                'label' => lang('Form.address.country'),
                'name' => 'country',
                'placeholder' => lang('Form.address.selectCountry'),
                'options' => \Btw\Core\Libraries\Data::getCountriesList(),
                'byKey' => true,
                'val' => "name",
                'default' => 'FR',
                'required' => true,
                'class' => "select2-country",
                'selected' => old('country', $company->country)
            ]); ?>


        </div>

        <div class="flex flex-wrap -mx-3 mb-4">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'tel',
                    'label' => lang('Form.address.phone'),
                    'name' => 'phone',
                    'value' => old('phone', $company->phone),
                    'lang' => false,
                    'class' => 'phoneintl'
                ]); ?>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                <?= view_cell('Btw\Core\Cells\Forms\InputCell::renderList', [
                    'type' => 'tel',
                    'label' => lang('Form.address.phone_mobile'),
                    'name' => 'phone_mobile',
                    'value' => old('phone_mobile', $company->phone_mobile),
                    'lang' => false,
                    'class' => 'phoneintl'
                ]); ?>

            </div>
        </div>

    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loadingcompany"]) ?>
    </div>

</div>