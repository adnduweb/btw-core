<div class="mb-4 flex">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-200 " data-cy="page-title"> <?= $message ?? '' ?></h1>
    <div class="ml-auto rtl:mr-auto">
        <?php if (!empty($add)) : ?>
            <a class="ml-2 inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 transition sm:text-sm" href="<?= route_to($add['href']); ?>">
                <?= theme()->getSVG('duotune/general/gen041.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true); ?>
                <span><?= $add['text']; ?></span>
            </a>
        <?php endif; ?>
        <?php if (!empty($back)) : ?>
            <a class="ml-2 inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 transition sm:text-sm" href="<?= route_to($back['href']); ?>">
                <?= theme()->getSVG('duotune/general/gen041.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true); ?>
                <span><?= $back['text']; ?></span>
            </a>
        <?php endif; ?>
    </div><!---->
</div>