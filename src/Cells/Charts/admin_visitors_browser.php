<div class="panel h-full sm:col-span-3 xl:col-span-2">
    <div class="flex items-start justify-between mb-5">
        <h5 class="font-semibold text-lg dark:text-white-light"><?= lang('Btw.VisitorsByBrowser'); ?></h5>
    </div>
    <div class="flex flex-col space-y-5">
        <?php if(!empty($allBrowser)) : ?>
            <?php foreach($allBrowser as $key => $value) : ?>

                <div class="flex items-center">
                    <div class="w-9 h-9">
                        <div class="bg-primary/10 text-primary rounded-xl w-9 h-9 flex justify-center items-center dark:bg-primary dark:text-white-light">
                            <?= theme()->getSVG(config('Visits')->browsers[strtolower($key)]['icon'], 'svg-icon flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 svg-white', true); ?>
                        </div>
                    </div>
                    <div class="px-3 flex-initial w-full">
                        <div class="w-summary-info flex justify-between font-semibold text-white-dark mb-1">
                            <h6><?= ucfirst($key); ?></h6>
                            <p class="ltr:ml-auto rtl:mr-auto text-xs"><?= count($value) ?></p>
                        </div>
                        <div>
                            <div class="w-full rounded-full h-5 p-1 bg-dark-light overflow-hidden shadow-3xl dark:bg-dark-light/10 dark:shadow-none">
                                <div class="bg-gradient-to-r from-[#<?= config('Visits')->browsers[strtolower($key)]['from']; ?>] to-[#<?= config('Visits')->browsers[strtolower($key)]['to']; ?>] w-full h-full rounded-full relative before:absolute before:inset-y-0 ltr:before:right-0.5 rtl:before:left-0.5 before:bg-white before:w-2 before:h-2 before:rounded-full before:m-auto" style="width: <?= count($value) ?>;"></div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>