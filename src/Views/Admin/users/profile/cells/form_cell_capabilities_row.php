<tr class="relative dark:hover:bg-gray-600 hover:bg-slate-50 list-group-item">
    <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200">
        <label class="form-check  form-check-sm form-check-custom form-check-solid <?= ($user->hasPermission($rowPermission[0])) ? 'checkbox-success' : '' ?>">
            <input class="permission_group selectable checkbox checkbox-primary rounded ml-1 w-5 h-5 ease-linear transition-all duration-150 border border-gray-200 focus:bg-white focus:border-gray-500 form-check-input 
            <?= $user->can($rowPermission[0]) ? 'in-group' : '' ?>" type="checkbox" name="permissions" value="<?= $rowPermission[0] ?>" 
            <?php if ($user->hasPermission($rowPermission[0])) : ?> checked="checked" <?php endif ?> 
            <?= ($user->inGroup('superadmin')) ? 'disabled checked="checked"' : '' ; ?> 
                hx-put="<?= route_to('user-permissions-toggle-only', $rowPermission[0]); ?>" hx-include="[name='type']" 
                hx-target="closest .list-group-item" 
                hx-trigger="click" hx-swap="outerHTML">
        </label>
    </td>
    <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200"><?= $rowPermission[0] ?></td>
    <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200"><?= $rowPermission[1] ?></td>
    
</tr>