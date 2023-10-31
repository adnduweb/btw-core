<div class="panel h-full sm:col-span-2 lg:col-span-1">
    <!-- statistics -->
    <div class="flex items-center justify-between dark:text-white-light mb-5">
        <h5 class="font-semibold text-lg "><?= lang('Btw.Statistiques'); ?></h5>
        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
            <a href="javascript:;" @click="toggle">
                <svg class="w-5 h-5 text-black/70 dark:text-white/70 hover:!text-primary" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="5" cy="12" r="2" stroke="currentColor" stroke-width="1.5" />
                    <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor" stroke-width="1.5" />
                    <circle cx="19" cy="12" r="2" stroke="currentColor" stroke-width="1.5" />
                </svg>
            </a>
        </div>
    </div>
    <div class="grid sm:grid-cols-1 gap-8 text-sm text-[#515365] font-bold">
        <div>
            <div>
                <div><?= lang('Btw.totalVisits'); ?></div>
                <div class="text-[#f8538d] text-lg"><?= $allVisits; ?></div>
            </div>
            <div x-ref="totalVisit" class="overflow-hidden"></div>
        </div>
    </div>
</div>