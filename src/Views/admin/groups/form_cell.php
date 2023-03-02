<div id="allergy_target" class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

        <div class="col-span-6 sm:col-span-4">
            <x-label for="title" label="<?= lang('Btw.name'); ?>" />
            <x-inputs.text name="title" value="<?= esc(old('title', $group['title'] ?? null)) ?>" description="false" />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('title'); ?>
                </div>
            <?php endif ?>
        </div>


        <div class="col-span-6 sm:col-span-4">
            <x-label for="description" label="<?= lang('Btw.description'); ?>" />
            <x-inputs.textarea name="description" value="<?= esc(old('description', $group['description'] ?? null)) ?>" description=" Brief description for your profile. URLs are hyperlinked." />
            <?php if (isset($validation)) :  ?>
                <div class="invalid-feedback block">
                    <?= $validation->getError('description'); ?>
                </div>
            <?php endif ?>
        </div>

    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" loading="loading" />
    </div>
</div>