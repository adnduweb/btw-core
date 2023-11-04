<div class="absolute z-10 hidden h-full w-full rounded-md bg-black/60 !block xl:!hidden" :class="{ '!block xl:!hidden': isShowMenuSidebar }" @click="isShowMenuSidebar = !isShowMenuSidebar"></div>
<div class="panel absolute z-10 hidden w-[240px] flex-none space-y-4 overflow-hidden p-4 ltr:rounded-r-none rtl:rounded-l-none ltr:lg:rounded-r-md rtl:lg:rounded-l-md xl:relative xl:block xl:h-auto shadow"
    hx-boost="true" :class="{ 'hidden shadow': !isShowMenuSidebar, 'h-full ltr:left-0 rtl:right-0': isShowMenuSidebar }">
    <div class="flex h-full flex-col pb-16">
        <nav class="py-1">
            <div class="my-4 h-px w-full border-b border-[#e0e6ed] dark:border-[#1b2e4b]"></div>
            <?php if (isset($menu)): ?>
                <div class="perfect-scrollbar relative -mr-3.5 h-full grow pr-3.5 ps ps--active-y">
                    <div class="space-y-1">
                        <?php foreach ($menu->collections() as $collection): ?>

                            <?php if ($collection->isCollapsible()): ?>
                                <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider"> <span>
                                        <?= $collection->title ?>
                                </p>

                                <div class="mt-2 space-y-1  <?= $collection->isActive() ? 'active' : 'flyout' ?>">
                                <?php endif ?>


                                <?php //print_r( $collection->items()); exit;
                                        //  print_r($collection->items());
                                        foreach ($collection->items() as $item): ?>
                                    <?php if ($item->userCanSee()): ?>
                                        <a <?= $item->target; ?> data-current="<?= $currentUrl ?>" data-url="<?= $item->url; ?>" class="flex h-10 w-full items-center justify-between rounded-md p-2 font-medium hover:bg-white-dark/10 hover:text-primary
                                             dark:hover:bg-[#181F32] dark:hover:text-primary
                                       
                                             
                                             
                                             
                                             <?= url_is($item->url . '*') ? 'bg-gray-100 dark:text-primary text-primary dark:bg-[#181F32]  active' : '' ?>" href="<?= $item->url ?>">
                                            <?= $item->icon ?>
                                            <span class="<?= $item->color; ?>">
                                                <?= $item->title ?>
                                            </span>
                                        </a>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <?php if ($collection->isCollapsible()): ?>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif ?>
        </nav>
    </div>
</div>