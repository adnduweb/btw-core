<div class="rounded-t bg-white mb-0 px-4 py-3 border-0">
    <div class="flex flex-wrap items-center">
        <div class="relative w-full px-4 max-w-full text-center flex justify-between items-center">
            <h3 class="font-semibold text-lg text-gray-700"> <?= $slot ?? '' ?></h3>
            <?php if (isset($lAdd)) : ?>
                <div class="flex flex-row">
                    <a class="bg-gray-700 hover:bg-gray-800 active:bg-gray-600 text-white font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150 flex flex-row justify-center items-center" href="<?= $lAdd; ?>">
                        <?= theme()->getSVG('duotune/general/gen041.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true); ?>
                        <span><?= $tAdd; ?></span>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (isset($lback)) : ?>
                <div class="flex flex-row">
                    <a class="bg-gray-700 hover:bg-gray-800 active:bg-gray-600 text-white font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150 flex flex-row justify-center items-center" href="<?= $lback; ?>">
                        <?= theme()->getSVG('duotune/arrows/arr079.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true); ?>
                        <span><?= $tback; ?></span>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>