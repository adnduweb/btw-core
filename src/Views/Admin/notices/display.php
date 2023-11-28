<?php if($notices->getItemsGlobal()) : ?>
<div class="mb-5 grid grid-cols-1 gap-5 lg:grid-cols-1">
    <?php foreach($notices->getItemsGlobal() as $notice) : ?>
    <div class="relative flex items-center rounded border border-<?= $notice->getBadge(); ?> bg-<?= $notice->getBadge(); ?>-light p-3.5 text-<?= $notice->getBadge(); ?> ltr:border-l-[64px] rtl:border-r-[64px] dark:bg-<?= $notice->getBadge(); ?>-dark-light">
        <span class="absolute inset-y-0 m-auto h-6 w-6 text-white ltr:-left-11 rtl:-right-11">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6">
                <path opacity="0.5" d="M5.31171 10.7615C8.23007 5.58716 9.68925 3 12 3C14.3107 3 15.7699 5.58716 18.6883 10.7615L19.0519 11.4063C21.4771 15.7061 22.6897 17.856 21.5937 19.428C20.4978 21 17.7864 21 12.3637 21H11.6363C6.21356 21 3.50217 21 2.40626 19.428C1.31034 17.856 2.52291 15.7061 4.94805 11.4063L5.31171 10.7615Z" stroke="currentColor" stroke-width="1.5"></path>
                <path d="M12 8V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                <circle cx="12" cy="16" r="1" fill="currentColor"></circle>
            </svg>
        </span>
        <span class="ltr:pr-2 rtl:pl-2"><strong class="ltr:mr-1 rtl:ml-1">Warning!</strong><?= nl2br($notice->getDescription()); ?></span>
        <button type="button" class="hover:opacity-80 ltr:ml-auto rtl:mr-auto">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>