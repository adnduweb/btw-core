<div class="w-64" hx-boost="true" >
    <div class="rounded-lg bg-white shadow overflow-hidden">
        <nav class="py-1">

            <?php if (isset($menu)) : ?>
                <?php foreach ($menu->collections() as $collection) : ?>

                    <div class="mt-10">
                        <nav class="nav flex-column px-0">
                            <?php if ($collection->isCollapsible()) : ?>
                                <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider"> <span><?= $collection->title ?></p>

                                <div class="mt-2 space-y-1  <?= $collection->isActive() ? 'active' : 'flyout' ?>">
                                <?php endif ?>


                                <?php foreach ($collection->items() as $item) : ?>
                                    <?php if ($item->userCanSee()) : ?>
                                        <a class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 <?= (in_array((string)$currentUrl, [$item->url])) ? "bg-gray-100" : ""; ?> <?= url_is($item->url . '*') ? 'active' : '' ?>" href="<?= $item->url ?>">
                                            <?= $item->icon ?>
                                            <span><?= $item->title ?></span>
                                        </a>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <?php if ($collection->isCollapsible()) : ?>
                                </div>
                            <?php endif ?>
                        </nav>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </nav>
    </div>
</div>