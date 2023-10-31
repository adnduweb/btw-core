
    <div class="flex justify-center">
        <a href="#" x-on:click="$dispatch(`authdisplaydatamodalcomponent`, {
        showAuthDisplayDataModal: true, 
        title: `Demande d'authorisation`, 
        message: `Veuillez insérez votre mot de passe`, 
        id: `<?= $row->getIdentifier(); ?>`, 
        module: `<?= $module; ?>`, 
        identifier: `<?= $row->getIdentifier(); ?>`, 
        actionHtmx: `<?= $hxTrigger ?? 'updateListrow'; ?>`, 
        route: `<?= route_to('system-auth-pass-modal'); ?>`})" class="bg-slate-600 hover:bg-slate-700 mx-auto flex items-center justify-center rounded-full border border-transparent px-10 py-2.5 font-medium text-white transition-colors sm:w-52 ease-in-out duration-1200 transition-all">
            <?= lang('Btw.askAccess'); ?>
        </a>
    </div>