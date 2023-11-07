<div class="dropdown" x-data="dropdown" @click.outside="open = false"  hx-get="<?= route_to('list-notification-not-read'); ?>" hx-trigger="updateNotification from:body">
    <a href="javascript:;" class="relative block p-2 rounded-full bg-white-light/40 dark:bg-dark/40 hover:text-primary hover:bg-white-light/90 dark:hover:bg-dark/60" @click="toggle">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.0001 9.7041V9C19.0001 5.13401 15.8661 2 12.0001 2C8.13407 2 5.00006 5.13401 5.00006 9V9.7041C5.00006 10.5491 4.74995 11.3752 4.28123 12.0783L3.13263 13.8012C2.08349 15.3749 2.88442 17.5139 4.70913 18.0116C9.48258 19.3134 14.5175 19.3134 19.291 18.0116C21.1157 17.5139 21.9166 15.3749 20.8675 13.8012L19.7189 12.0783C19.2502 11.3752 19.0001 10.5491 19.0001 9.7041Z" stroke="currentColor" stroke-width="1.5" />
            <path d="M7.5 19C8.15503 20.7478 9.92246 22 12 22C14.0775 22 15.845 20.7478 16.5 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            <path d="M12 6V10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>

        <?php if (count($notifications) > 0) :  ?>
        <span class="flex absolute w-3 h-3 ltr:right-0 rtl:left-0 top-0">
            <span class="animate-ping absolute ltr:-left-[3px] rtl:-right-[3px] -top-[3px] inline-flex h-full w-full rounded-full bg-success/50 opacity-75"></span>
            <span class="relative inline-flex rounded-full w-[6px] h-[6px] bg-success"></span>
        </span>
        <?php endif; ?>
    </a>
    <ul x-cloak x-show="open" x-transition="" x-transition.duration.300ms="" class="top-11 w-[300px] !py-0 text-xs text-dark ltr:-right-16 rtl:-left-16 dark:text-white-dark sm:w-[375px] sm:ltr:-right-2 sm:rtl:-left-2">
            <li class="mb-5">
            <div class="overflow-hidden relative rounded-t-md !p-5 text-white">
                <div class="absolute h-full w-full bg-[url('/admin/images/menu-heade.jpg')] bg-no-repeat bg-center bg-cover inset-0"></div>
                <h4 class="font-semibold relative z-10 text-lg">Notifications</h4>
            </div>
        </li>
        <?php foreach ($notifications as $notification) : ?>
            <li>
                <div class="flex items-center px-5 py-3" @click.self="toggle">
                    <div>
                        <?= $notification->getIcon(); ?>
                    </div>
                    <span class="px-3 dark:text-gray-500">
                        <div class="font-semibold text-sm dark:text-white-light/90"><?= $notification->title; ?></div>
                        <div><?= $notification->body; ?></div>
                    </span>
                    <span class="font-semibold bg-white-dark/20 rounded text-dark/60 px-1 ltr:ml-auto rtl:mr-auto whitespace-pre dark:text-white-dark ltr:mr-2 rtl:ml-2"><?= $notification->getTimestamp(); ?> </span>
                    <span class="text-neutral-300 hover:text-danger" @click="removeMessage(msg.id)">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                            <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </span>
                </div>
            </li>
        <?php endforeach;?>
        <?php if (count($notifications) > 4) :  ?>

            <!-- <li class="mt-5 border-t border-white-light text-center dark:border-white/10">
                <div class="group flex cursor-pointer items-center justify-center px-4 py-4 font-semibold text-primary dark:text-gray-400" @click="toggle">
                    <span class="group-hover:underline ltr:mr-1 rtl:ml-1"><?= lang('Btw.ReadAllNotifications'); ?></span>
                    <svg class="h-4 w-4 transition duration-300 group-hover:translate-x-1 ltr:ml-1 rtl:mr-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12H20M20 12L14 6M20 12L14 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
            </li> -->

            <li>
                <div class="p-4">
                    <button class="btn btn-primary block w-full btn-small"><?= lang('Btw.ReadAllNotifications'); ?></button>
                </div>
            </li>
        <?php endif; ?>
        <?php if (count($notifications) == 0) :  ?>
            <li>
                <div class="!grid place-content-center hover:!bg-transparent text-lg min-h-[200px]">
                    <div class="mx-auto ring-4 ring-primary/30 rounded-full mb-4 text-primary">
                        <svg width="40" height="40" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" d="M20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20C15.5228 20 20 15.5228 20 10Z" fill="currentColor" />
                            <path d="M10 4.25C10.4142 4.25 10.75 4.58579 10.75 5V11C10.75 11.4142 10.4142 11.75 10 11.75C9.58579 11.75 9.25 11.4142 9.25 11V5C9.25 4.58579 9.58579 4.25 10 4.25Z" fill="currentColor" />
                            <path d="M10 15C10.5523 15 11 14.5523 11 14C11 13.4477 10.5523 13 10 13C9.44772 13 9 13.4477 9 14C9 14.5523 9.44772 15 10 15Z" fill="currentColor" />
                        </svg>
                    </div>
                    No data available.
                </div>
            </li>
        <?php endif; ?>
    </ul>
</div>