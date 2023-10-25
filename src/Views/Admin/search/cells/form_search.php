<?php if (!empty($notes)) : ?>
    <div class="mx-auto py-6 ">
        <div class="mx-auto max-w-none">
            <div class="overflow-hidden bg-white sm:rounded-lg sm:shadow">

                <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900"><?= lang('Btw.notes'); ?></h3>
                </div>

                <ul role="list" class="divide-y divide-gray-200" ht-boost="true">

                    <?php foreach ($notes as $res) : ?>

                        <li>
                            <a  x-on:click="showSlideOver = false" href="<?= route_to('notes-list'); ?>" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="truncate text-sm font-medium text-indigo-600"> <?= $res->titre; ?></div>
                                        <div class="ml-2 flex flex-shrink-0">
                                            <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">F <?= $res->created_at; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

<?php endif; ?>