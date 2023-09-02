<?php 
if (isset($actions) && $actions->getAll() == true) :?>
    <?php $identifiant = isset($row->uuid) ? $row->getIdentifierUUID() : $row->getIdentifier();  ?>
    <td class="text-end">
        <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
            <div @click="open = ! open" class="">
                <button hx-get="/admin/user/update" hx-trigger="updateAvatar from:body" type="button" class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-slate-800" aria-expanded="false" aria-haspopup="true">
                    <?= service('theme')->getSVG('duotune/general/gen053.svg', 'svg-icon svg-icon-1 position-absolute ms-6', false, true); ?>
                </button>
            </div>

            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 my-2 w-48 rounded-md shadow-lg origin-top-right right-0 top-full" style="display: none;" @click="open = false">
                <div class=" divide-y divide-gray-100 rounded-md ring-1 ring-black ring-opacity-5 dark:ring-slate-600 py-1 bg-white dark:bg-slate-800">
                <div class="py-2">
                    <?php if ($actions->edit()) : ?> 
                        <a class="block px-4 py-2 text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-700 dark:hover:bg-slate-700" href="<?= $row->getUrlEditAdmin(); ?>"><?= ucfirst(lang('Btw.general.edit')); ?></a>
                    <?php endif ?>

                    <?php if ($actions->delete()) : ?>
                        <a class="block px-4 py-2 text-sm leading-5 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-700 dark:hover:bg-slate-700 text-red-700" href="#" data-identifier="<?= $identifiant; ?>" data-kt-datatable-filter="delete_row"><?= ucfirst(lang('Btw.general.delete')); ?></a>
                    <?php endif ?>

                    <?php if ($actions->custom()) : ?>
                        </div>
    
                        <?php foreach ($actions->custom()['list'] as $cus) : ?>
                            <?php if (isset($cus['modal'])) :  ?>
                                <a x-on:click="$dispatch(`modalcomponent`, {<?= $cus['type']; ?>: true})" class="block px-4 py-2 text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-700 dark:hover:bg-slate-700" hx-get="<?=route_to($cus['route'], $identifiant); ?>" hx-swap="innerHTML" hx-target="#<?= $cus['identifier']; ?>"><?= ucfirst(lang($actions->custom()['module'] . '.general.' . $cus['name'])); ?></a>
                            <?php else: ?>
                                <a <?= (isset($cus['target'])) ? 'target= "'.$cus['target'].'"' : '' ; ?> class="block px-4 py-2 text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out dark:text-slate-200 dark:focus:bg-slate-700 dark:hover:bg-slate-700" href="<?=route_to($cus['route'], $identifiant); ?>"><?= ucfirst(lang($actions->custom()['module'] . '.general.' . $cus['name'])); ?></a>
                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif ?>

                </div>
            </div>
        </div>
    </td>
<?php endif ?>