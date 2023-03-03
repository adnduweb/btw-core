<div id="dateandtime" class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

        <h6 class="text-slate-400 text-sm mt-5 mb-6 font-bold uppercase">Date and Time Settings</h6>

        <!-- Timezone -->
        <div class="flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4">
                <div class="relative w-full mb-3">
                    <label for="timezone" class="block uppercase text-gray-600 text-xs font-bold mb-2">Timezone</label>
                    <select name="timezoneArea" class="border-0 px-3 py-3 placeholder-gray-300 text-gray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" hx-get="/<?= ADMIN_AREA ?>/settings/timezones" hx-target="#timezone" hx-include="[name='timezoneArea']" hx-trigger="change" hx-swap="afterSettle">
                        <option>Select timezone...</option>
                        <?php foreach ($timezones as $timezone) : ?>
                            <option value="<?= $timezone ?>" <?php if ($currentTZArea === $timezone) : ?> selected <?php endif ?>>
                                <?= $timezone ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="w-full lg:w-6/12 px-4">
                <div class="relative w-full mb-3">
                    <label for="timezone" class="block uppercase text-gray-600 text-xs font-bold mb-2">Pays</label>
                    <select name="timezone" id="timezone" class="border-0 px-3 py-3 placeholder-gray-300 text-gray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
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
                <label for="timezone" class="block uppercase text-gray-600 text-xs font-bold mb-2">Date &amp; Time Format</label>

                <div class="form-check mb-3">
                    <input class="form-check-input form-checkbox border-0 rounded-3xl text-blueGray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="radio" name="dateFormat" value="m/d/Y" <?php if (old('dateFormat', $dateFormat) === 'm/d/Y') : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="dateFormat">
                        mm/dd/yyyy
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input form-checkbox border-0 rounded-3xl text-blueGray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="radio" name="dateFormat" value="d/m/Y" <?php if (old('dateFormat', $dateFormat) === 'd/m/Y') : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="dateFormat">
                        dd/mm/yyyy
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input form-checkbox border-0 rounded-3xl text-blueGray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="radio" name="dateFormat" value="d-m-Y" <?php if (old('dateFormat', $dateFormat) === 'd-m-Y') : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="dateFormat">
                        dd-mm-yyyy
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input form-checkbox border-0 rounded-3xl text-blueGray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="radio" name="dateFormat" value="Y-m-d" <?php if (old('dateFormat', $dateFormat) === 'Y-m-d') : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="dateFormat">
                        yyyy-mm-dd
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input form-checkbox border-0 rounded-3xl text-blueGray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="radio" name="dateFormat" value="M j, Y" <?php if (old('dateFormat', $dateFormat) === 'M j, Y') : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="dateFormat">
                        mmm dd, yyyy
                    </label>
                </div>
            </div>

            <!-- Time Format -->
            <div class="row mt-4">
                <div class="col-12 col-sm-4">

                    <div class="form-check mb-3">
                        <input class="form-check-input form-checkbox border-0 rounded-3xl text-blueGray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="radio" name="timeFormat" value="g:i A" <?php if (old('timeFormat', $timeFormat) === 'g:i A') : ?> checked <?php endif ?>>
                        <label class="form-check-label" for="timeFormat">
                            12 hour with AM/PM
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input form-checkbox border-0 rounded-3xl text-blueGray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="radio" name="timeFormat" value="H:i" <?php if (old('timeFormat', $timeFormat) === 'H:i') : ?> checked <?php endif ?>>
                        <label class="form-check-label" for="timeFormat">
                            24 hour
                        </label>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingdateandtime" />
    </div>

</div>