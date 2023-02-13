<a class="px-3 d-block fs-3 text-light text-decoration-none me-0" href="/<?= ADMIN_AREA ?>">
    <div class="site-stamp rounded d-inline-flex align-content-center justify-content-center">
        <?= substr(setting('Site.siteName') ?? 'bonfire', 0, 1) ?>
    </div>
    <span class="site-name"><?= setting('Site.siteName') ?? 'bonfire' ?></span>
</a>
<div class="pt-3">

    <!-- Dashboard -->
    <ul class="nav flex-column">
        <li class="nav-item items-center">
            <a class="text-xs uppercase py-3 font-bold block text-gray-700 hover:text-gray-500 <?= url_is('/' . ADMIN_AREA) ? 'active' : '' ?>" href="/<?= ADMIN_AREA ?>" title="Dashboard">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    <?php if (isset($menu)) : ?>
        <?php foreach ($menu->collections() as $collection) : ?>

            <div>
                <ul class="nav flex-column px-0">
                    <?php if ($collection->isCollapsible()) : ?>
                        <li class="nav-item items-center">
                            <h6 class="md:min-w-full text-gray-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline <?= $collection->isActive() ? 'active' : '' ?>">
                                <?= $collection->icon ?>
                                <span><?= $collection->title ?></span>
                            </h6>
                        </li>
                        <ul class="nav subnav flex-column mb-2 md:flex-col md:min-w-full flex flex-col list-none  <?= $collection->isActive() ? 'active' : 'flyout' ?>">
                        <?php endif ?>


                        <?php foreach ($collection->items() as $item) : ?>
                            <?php if ($item->userCanSee()) : ?>
                                <li class="nav-item items-center">
                                    <a class="text-xs uppercase py-3 font-bold block text-gray-700 hover:text-gray-500 <?= url_is($item->url . '*') ? 'active' : '' ?>" href="<?= $item->url ?>">
                                        <?php if (!$collection->isCollapsible()) : ?>
                                            <?= $item->icon ?>
                                        <?php endif ?>
                                        <span><?= $item->title ?></span>
                                    </a>
                                </li>
                            <?php endif ?>
                        <?php endforeach ?>
                        <?php if ($collection->isCollapsible()) : ?>
                        </ul>
                    <?php endif ?>
                </ul>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>