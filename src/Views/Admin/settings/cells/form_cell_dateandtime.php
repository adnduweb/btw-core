<div id="dateandtime" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.cellh3.DateAndTimeSettings'); ?></h3>

        <!-- Timezone -->
        <div class="flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4">
                <div class="relative w-full mb-3">

                    <?= view_cell('Btw\Core\Cells\Forms\SelectCell::renderList', [
                        'label' => lang('Form.settings.Timezone'),
                        'name' => 'timezoneArea',
                        'options' => $timezones,
                        'selected' => $currentTZArea,
                        'byKey' => true,
                        'hxGet' => "/" . ADMIN_AREA . "/settings/timezones",
                        'hxTarget' => "#timezone",
                        'hxInclude' => "[name='timezoneArea']",
                        'hxTrigger' => "change",
                        'hxSwap' => "afterSettle"
                    ]); ?>

                </div>
            </div>
            <div class="w-full lg:w-6/12 px-4">
                <div class="relative w-full mb-3">
                    <label for="timezone" class="block text-sm font-medium text-gray-700 mt-px pb-2"><?=  lang('Form.general.country'); ?></label>
                    <select name="timezone" id="timezone" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500  dark:text-gray-200 dark:bg-gray-900 ease-linear transition-all duration-150">
                        <?php if (isset($timezoneOptions) && !empty($timezoneOptions)) : ?>
                            <?= $timezoneOptions ?>
                        <?php else : ?>
                            <option value="0">No timezones</option>
                        <?php endif ?>
                    </select>
                </div>

            </div>
        </div>

        <!-- Date Format -->
        <div class="row mt-4">
            <div class="col-12 col-sm-4">

                <label for="timezone" class="block text-sm font-medium text-gray-700 mt-px pt-2 dark:text-gray-300">Date &amp; Time Format</label>

                <div class="form-check ml-4 mb-2 mt-2 ">
                    <?= view_cell('Btw\Core\Cells\Forms\RadioCell::renderList', ['label' =>lang('Form.time.mm/dd/yyyy'), 'name' => 'dateFormat', 'value' => 'm/d/Y', 'checked' => (old('dateFormat', $dateFormat) === 'm/d/Y')]); ?>
                </div>

                <div class="form-check ml-4 mb-2 mt-2 ">
                    <?= view_cell('Btw\Core\Cells\Forms\RadioCell::renderList', ['label' => lang('Form.time.dd/mm/yyyy'), 'name' => 'dateFormat', 'value' => 'd/m/Y', 'checked' => (old('dateFormat', $dateFormat) === 'd/m/Y')]); ?>
                </div>

                <div class="form-check ml-4 mb-2 mt-2 ">
                    <?= view_cell('Btw\Core\Cells\Forms\RadioCell::renderList', ['label' => lang('Form.time.dd-mm-yyyy'), 'name' => 'dateFormat', 'value' => 'd-m-Y', 'checked' => (old('dateFormat', $dateFormat) === 'd-m-Y')]); ?>
                </div>

                <div class="form-check ml-4 mb-2 mt-2 ">
                    <?= view_cell('Btw\Core\Cells\Forms\RadioCell::renderList', ['label' => lang('Form.time.yyyy-mm-dd'), 'name' => 'dateFormat', 'value' => 'Y-m-d', 'checked' => (old('dateFormat', $dateFormat) === 'Y-m-d')]); ?>
                </div>

                <div class="form-check ml-4 mb-2 mt-2 ">
                    <?= view_cell('Btw\Core\Cells\Forms\RadioCell::renderList', ['label' => lang('Form.time.mm dd, yyyy'), 'name' => 'dateFormat', 'value' => 'M j, Y', 'checked' => (old('dateFormat', $dateFormat) === 'M j, Y')]); ?>
                </div>

            </div>

            <!-- Time Format -->
            <div class="row mt-4">
                <div class="col-12 col-sm-4">

                    <div class="form-check ml-4 mb-2 mt-2 ">
                        <?= view_cell('Btw\Core\Cells\Forms\RadioCell::renderList', ['label' => lang('Form.time.12 hour with AM/PM'), 'name' => 'timeFormat', 'value' => 'g:i A', 'checked' => (old('timeFormat', $timeFormat) === 'g:i A')]); ?>
                    </div>

                    <div class="form-check ml-4 mb-2 mt-2 ">
                        <?= view_cell('Btw\Core\Cells\Forms\RadioCell::renderList', ['label' => lang('Form.time.24 hour'), 'name' => 'timeFormat', 'value' => 'H:i', 'checked' => (old('timeFormat', $timeFormat) === 'H:i')]); ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <?= view_cell('Btw\Core\Cells\Forms\AdminButtonSave', ['type' => 'type', 'text' => lang('Btw.save'), 'loading' => "loadingdateandtime"]) ?>
    </div>

</div>