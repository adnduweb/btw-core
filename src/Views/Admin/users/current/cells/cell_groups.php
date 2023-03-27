<div id="modalgroups" hx-trigger="load">
    <?php if (isset($groups) && count($groups)) : ?>
        <!-- Default Group -->
        <div class="row">
            <div class="col-12 col-sm-4">

                <label class="form-label dark:text-gray-300">Default User Group:</label>

                <?php foreach ($groups as $group => $info) : ?>
                    <div class="form-check dark:text-gray-200">
                        <input class="form-check-input" type="checkbox" name="currentGroup[]" value="<?= $group ?>" <?php if (isset($currentGroup[$group])) : ?> checked <?php endif ?>>
                        <label class="form-check-label" for="currentGroup">
                            <?= esc($info['title']) ?>
                        </label>
                    </div>
                <?php endforeach ?>

            </div>
            <div class="col px-5 py-4">
                <p class="text-muted small dark:text-gray-300">The user group newly registered users are members of.</p>
            </div>
        </div>
    <?php endif ?>

    <?php if (isset($validation)) : ?>
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif ?>

    <div class="px-4 py-3 text-right sm:px-6 ">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingmodalgroups" />
    </div>

</div>