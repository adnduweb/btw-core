<div class="mb-4 flex">
    <h1 class="text-2xl font-semibold text-gray-900" data-cy="page-title"> <?= $slot ?? '' ?></h1>
    <div class="ml-auto rtl:mr-auto">
        <?php if (isset($lAdd)) : ?>
            < <a class="bg-gray-700 hover:bg-gray-800 active:bg-gray-600 text-white font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150 flex flex-row justify-center items-center" href="<?= $lAdd; ?>">
                <?= theme()->getSVG('duotune/general/gen041.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true); ?>
                <span><?= $tAdd; ?></span>
                </a>
            <?php endif; ?>
            <?php if (isset($lback)) : ?>
                <a class="bg-gray-700 hover:bg-gray-800 active:bg-gray-600 text-white font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150 flex flex-row justify-center items-center" href="<?= $lback; ?>">
                    <?= theme()->getSVG('duotune/arrows/arr079.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true); ?>
                    <span><?= $tback; ?></span>
                </a>
            <?php endif; ?>
    </div><!---->
</div>