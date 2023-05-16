<div id="modalgroups" hx-trigger="load">
    <?php if (isset($groups) && count($groups)): ?>
        <!-- Default Group -->
        <div class="row  px-8 pb-8">
            <div class="col-12 col-sm-4">

                <label class="form-label dark:text-gray-300 mb-5 block">
                    <?= lang('Form.settings.DefaultUserGroup'); ?>
                </label>

                <?php foreach ($groups as $group => $info): ?>
                    <div class="relative flex items-start">
                        <div class="flex h-6 items-center">
                            <input class="form-check-input" type="checkbox" name="currentGroup[]" value="<?= $group ?>" <?php if (isset($currentGroup[$group])): ?> checked <?php endif ?>>
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="comments" class="font-medium text-gray-900">
                                <?= esc($info['title']) ?>
                            </label>
                            <p id="comments-description" class="text-gray-500">
                                <?= esc($info['description']) ?>
                            </p>
                        </div>

                    </div>
                <?php endforeach ?>

                <div class="col px-5 py-4">
                    <p class="text-muted small dark:text-gray-300">
                        <?= lang('Form.settings.TheUserGroupNewlyRegisteredUsersAreMembersOf'); ?>
                    </p>
                </div>

                <?php if (isset($validation)): ?>
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        <?= $validation->listErrors() ?>
                    </div>
                <?php endif ?>
            </div>

        </div>
    <?php endif ?>

    <div class="flex flex-row justify-end px-6 py-3 bg-gray-100 text-right">
        <div>
            <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingmodalgroups" />
        </div>
    </div>

</div>