<tr class="relative dark:hover:bg-gray-600 hover:bg-slate-50 " >
    <td class="border-dashed border-t border-gray-300  px-3"><span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200"  x-on:click="location.replace('<?= site_url(route_to('group-show', $group['alias'])); ?>')">
            <?= $group['title']; ?></span>
    </td>
    <td class="border-dashed border-t border-gray-300"><span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200"  x-on:click="location.replace('<?= site_url(route_to('group-show', $group['alias'])); ?>')">
            <?= $group['description']; ?></span>
    </td>
    <td class="border-dashed border-t border-gray-300"><span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200"  x-on:click="location.replace('<?= site_url(route_to('group-show', $group['alias'])); ?>')">
            <?= $group['alias']; ?></span>
    </td>
    <td class="border-dashed border-t border-gray-300"><span class="text-gray-700 px-6 py-3 flex items-center cursor-pointer  dark:text-gray-200"  x-on:click="location.replace('<?= site_url(route_to('group-show', $group['alias'])); ?>')">
            <?= $group['user_count']; ?></span>
    </td>
    <!-- <td class="text-end border-dashed border-t border-gray-300  px-3">
        <a hx-get="<?= site_url('groups-list/edit/' . $group['user_count']); ?>" hx-target="closest tr" hx-swap="outerHTML" class="btn btn-sm btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path><line x1="13.5" y1="6.5" x2="17.5" y2="10.5"></line></svg>
            Edit
        </a>
        <a hx-delete="<?= site_url('groups-list/delete/' . $group['user_count']); ?>" hx-confirm="Are you sure?" hx-target="closest tr" hx-swap="outerHTML" class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="4" y1="7" x2="20" y2="7"></line><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg>
            Delete
        </a>
    </td> -->

    <td class="relative border-dashed border-t border-gray-300 w-56">
        <div class="flex">
            <!-- <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" wire:click="$emitTo('admin.shipping-rate-form', 'edit', '1')" role="button">Edit rate</a>
        <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" x-on:click.prevent="emitTo('<?= site_url('groups-list/delete/' . $group['user_count']); ?>', 'delete', '1')" role="button"><span class="text-red-600">Delete</span></a> -->

            <x-button-edit route_to="<?= route_to('group-show', $group['alias']); ?>" text=false />
            <x-button-delete route_to="<?= route_to('group-delete', $group['user_count']); ?>" />
        </div>

    </td>

</tr>