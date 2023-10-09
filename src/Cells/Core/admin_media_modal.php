<?php
if ($banner == true) : ?>
    <div id="displayMediaOnly" class="col-span-6 ml-2 sm:col-span-4 md:mr-3">
        <div class="relative pb-48 overflow-hidden">
            <img data-media-file="<?= service('storage')->getPlaceholder(['size' => 'image300x300']); ?>" class="absolute inset-0 h-full w-full object-cover" src="<?= service('storage')->getPlaceholder(['size' => 'image300x300']); ?>" alt="">
        </div>
        <input class="" type="hidden" name="media_id" value="" />
    </div>

    <button type="button" class="inline-flex w-full justify-center cursor-pointer bg-blue-500 text-white active:bg-blue-600 dark:bg-gray-900  font-bold px-4 py-2 text-sm rounded-md shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-in-out duration-1200 transition-all" hx-get="<?= route_to('media-modal-display'); ?>?container=imagealaunePreview&identifier=media_id&multiple:false&media=true" hx-target="#<?= $target; ?>" hx-swap="innerHTML" x-on:click="$dispatch(`modalcomponent`, {showMediaDropzoneModal: true })">Ajouter un média
    </button>
<?php else : ?>

    <?php if ($multiple == false) : ?>
        <div class="flex justify-center mt-8">
            <div class="w-80 rounded-lg bg-gray-50">
                <div id="displayMediaOnly" class="m-4">
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col w-full h-32 border-4 border-blue-200 border-dashed hover:bg-gray-100 hover:border-gray-300 relative">
                            <div class="flex flex-col items-center justify-center pt-7 ">
                                <img data-media-file="<?= service('storage')->getFileUrl($media->getIdentifier(), ['size' => 'image300x300']); ?>" class="absolute inset-0 h-full w-full object-cover" src="<?= service('storage')->getFileUrl($media->getIdentifier(), ['size' => 'image300x300']); ?>" alt="<?= $media->getAlt(); ?>" title="<?= $media->getTitle(); ?>">
                            </div>
                            <input class="" type="hidden" name="media_id" value="<?= $media->getIdentifierUUID(); ?>" />
                        </label>
                    </div>
                </div>
                <div class="flex justify-center p-2">
                    <button type="button" class="inline-flex w-full justify-center cursor-pointer bg-blue-500 text-white active:bg-blue-600 dark:bg-gray-900 font-bold px-4 py-2 text-sm rounded-md shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-in-out duration-1200 transition-all" hx-get="<?= route_to('media-modal-display'); ?>?container=imagealaunePreview&identifier=media_id&multiple:false&media=true" hx-target="#<?= $target; ?>" hx-swap="innerHTML" x-on:click="$dispatch(`modalcomponent`, {showMediaDropzoneModal: true })">Ajouter un média
                    </button>
                </div>
            </div>
        </div>
    <?php else : ?>
    <?php endif; ?>


<?php endif; ?>