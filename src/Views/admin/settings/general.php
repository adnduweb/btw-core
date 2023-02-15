<?= $this->extend(config('Auth')->views['layout']) ?>

<?php $this->section('main') ?>


<x-page-head>Settings </x-page-head>

<x-admin-box>
    <?= form_open(route_to('/admin/settings/general'), ['id' => 'kt_groups_form', 'hx-post' => "/admin/settings/general", 'hx-include' => '[name=' . csrf_token() . ']', 'hx-swap' => 'none', 'novalidate' => false, 'hx-ext' => 'json-enc']); ?>


    <!-- <form hx-post="/admin/settings/general" hx-include="[name='<?= csrf_token() ?>']" hx-swap="none" data-action="/admin/settings/general" data-method="post"> -->


    <h6 class="text-slate-400 text-sm mt-5 mb-6 font-bold uppercase">General</h6>

    <!-- Site Name -->
    <div class="row">
        <div class="col-12 col-sm-4">
            <div class="form-check">
                <label class="block uppercase text-gray-600 text-xs font-bold mb-2" for="siteName">Site Name</label>
                <input type="text" class="border-0 px-3 py-3 placeholder-gray-300 text-gray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" name="siteName" value="<?= esc(old('siteName', setting('Site.siteName')), 'attr') ?>" />
            </div>
        </div>
        <div class="col px-5">
            <p class="text-muted small text-sm text-gray-500">Appears in admin, and is available throughout the site.</p>
        </div>
    </div>

    <!-- Site Online? -->
    <div class="row mt-3">
        <div class="col-12 col-sm-4">
            <div class="form-check py-3 px-5">
                <input class="form-check-input form-checkbox border-0 rounded text-blueGray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" type="checkbox" name="siteOnline" value="1" <?php if (old('siteOnline', setting('Site.siteOnline') ?? false)) : ?> checked <?php endif ?> />
                <label class="form-check-label" for="siteOnline">
                    Site Online?
                </label>
            </div>
        </div>
        <div class="col px-5 pt-3">
            <p class="text-muted small">If unchecked, only Superadmin and user groups with permission can access the site.</p>
        </div>
    </div>

    <hr class="my-5 border-b-1 border-gray-300">


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

    <hr class="my-5 border-b-1 border-gray-300">

    <div class="text-end px-5 py-3">
        <input type="submit" value="Save Settings" class="cursor-pointer bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
    </div>
    <?= form_close(); ?>
</x-admin-box>
</div <?php $this->endSection() ?>