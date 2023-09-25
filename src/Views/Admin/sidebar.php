<div class="py-6 px-2 sm:px-6 lg:col-span-3 lg:py-0 lg:px-0 bg-white dark:bg-gray-800 shadow sm:rounded-md sm:overflow-hidden" hx-boost="true">
    <div class="rounded-lg dark:bg-gray-800 dark:shadow overflow-hidden">
        <nav class="py-1">

            <?php if (isset($menu)) : ?>
                <?php foreach ($menu->collections() as $collection) : ?>

                    <div class="mt-10">
                        <nav class="nav flex-column px-0">
                            <?php if ($collection->isCollapsible()) : ?>
                                <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider"> <span><?= $collection->title ?></p>

                                <div class="mt-2 space-y-1  <?= $collection->isActive() ? 'active' : 'flyout' ?>">
                                <?php endif ?>


                                <?php //print_r( $collection->items()); exit;
                                //  print_r($collection->items());
                                foreach ($collection->items() as $item) : ?>
                                    <?php if ($item->userCanSee()) : ?>
                                        <a <?= $item->target; ?> data-current="<?= $currentUrl ?>" data-url="<?= $item->url; ?>" class="flex items-center px-4 py-2 mt-2 text-sm text-<?= $item->bg; ?>-700 bg-<?= $item->bg; ?>-100 dark:text-<?= $item->bg; ?>-300 hover:bg-white hover:text-<?= $item->bg; ?>-900 dark:hover:bg-<?= $item->bg; ?>-700 <?= (in_array($currentUrl, [base_url($item->url)])) ? "bg-" . $item->bg . "-200 dark:bg-" . $item->bg . "-600  " : ""; ?> <?= url_is($item->url . '*') ? 'active' : '' ?>" href="<?= $item->url ?>">
                                            <?= $item->icon ?>
                                            <span class="<?= $item->color; ?>"><?= $item->title ?></span>
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