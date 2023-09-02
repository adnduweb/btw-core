<tr class="relative dark:hover:bg-gray-600 hover:bg-slate-50 " id="row_group_<?= $group['alias'] ?>" hx-boost="true">
    <td class="border-dashed border-t border-gray-300">
        <a href="<?= site_url(route_to('group-show', $group['alias'])); ?>">
            <span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200">
                <?= $group['title']; ?>
            </span>
        </a>
    </td>
    <td class="border-dashed border-t border-gray-300">
        <a href="<?= site_url(route_to('group-show', $group['alias'])); ?>">
            <span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200">
                <?= $group['description']; ?>
            </span>
        </a>
    </td>
    <td class="border-dashed border-t border-gray-300">
        <a href="<?= site_url(route_to('group-show', $group['alias'])); ?>">
            <span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200">
                <?= $group['alias']; ?>
            </span>
        </a>
    </td>
    <td class="border-dashed border-t border-gray-300">
        <a href="<?= site_url(route_to('group-show', $group['alias'])); ?>">
            <span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200">
                <?= $group['user_count']; ?>
            </span>
        </a>
    </td>

    <td class="relative border-dashed border-t border-gray-300 w-56">
        <div class="flex">
            <?= view_cell('Btw\Core\Cells\Core\AdminDeleteModal', ['group' => $group]) ?>
        </div>
    </td>

</tr>