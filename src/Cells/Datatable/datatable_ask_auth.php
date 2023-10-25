
    <div class="flex justify-center p-5">
        <a href="#" x-on:click="$dispatch(`authdisplaydatamodalcomponent`, {
        showAuthDisplayDataModal: true, 
        title: `Demande d'authorisation`, 
        message: `Veuillez insérez votre mot de passe`, 
        id: `<?= $row->getIdentifier(); ?>`, 
        module: `note`, 
        identifier: `<?= $row->getIdentifier(); ?>`, 
        actionHtmx: `updateListrow`, 
        route: `<?= route_to('system-auth-pass-modal'); ?>`})" class="inline-flex justify-center cursor-pointer bg-blue-500 text-white active:bg-blue-600 dark:bg-gray-900 font-bold px-4 py-2 text-sm rounded-md shadow hover:shadow-md outline-none focus:outline-none ease-in-out duration-1200 transition-all">
            <?= lang('Btw.accedeData'); ?>
        </a>
    </div>