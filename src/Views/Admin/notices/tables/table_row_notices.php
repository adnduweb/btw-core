<?php ''; //print_r($notice);exit;?>
<tr class="notice" data-uuid="<?= $notice->getIdentifier(); ?>">

    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-500 sm:pl-0" >
        ghjkjghkghjk
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500" >
        <?= $notice->titre; ?>
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500" >
        
       lhjkljklj
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= $notice->created_at; ?></td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
            <a href="#" x-on:click="$dispatch(`modalcomponent`, {showNoticeModal: true})" hx-get="<?= route_to('notice-update', $notice->getIdentifier()); ?>" hx-swap="innerHTML" hx-target="#addnotice" class="text-indigo-600 hover:text-indigo-900"><?= lang('Btw.edit'); ?><span class="sr-only">,  <?= $notice->titre; ?></span></a>
        <a href="#" x-on:click="$dispatch(`deletemodalcomponent`, {
            showDeleteModal: true, 
            title: `Suppression d'adresse`, 
            message: `Êtes-vous sûr de vouloir supprimer le notice : <?= $notice->titre; ?>`, 
            id: `<?= $notice->getIdentifier(); ?>`, 
            route: `<?= route_to('notice-delete', $notice->getIdentifier()); ?>`})" class="text-red-600 hover:text-red-900"><?= lang('Btw.delete'); ?><span class="sr-only">, <?= $notice->titre; ?></span></a>
    </td>
</tr>