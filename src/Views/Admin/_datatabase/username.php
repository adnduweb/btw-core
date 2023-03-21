<div class="flex items-center">
    <div class="flex-shrink-0 h-10 w-10">
        <a class="text-blue-700" href="/<?= ADMIN_AREA; ?>/users/edit/<?= $row->id; ?>/information">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-500">
                <span class="font-medium leading-none text-white">TW</span>
            </span>
        </a>
    </div>
    <div class="ml-4">
        <div class="text-sm text-gray-900 font-bold"><a class="text-blue-700" href="/<?= ADMIN_AREA; ?>/users/edit/<?= $row->id; ?>/information"><?= ucfirst($row->username); ?></a></div>
        <div class="text-sm text-gray-500">
            <?= $row->last_name; ?> <?= $row->first_name; ?>
        </div>
    </div>
</div>