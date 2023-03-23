<tr class="relative dark:hover:bg-gray-600 hover:bg-slate-50 list-group-item">
    <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200">
        <label class="form-check  form-check-sm form-check-custom form-check-solid <?= isset($matrix[$permission]) ? 'checkbox-success' : '' ?>"">
            <input class="permission_group selectable checkbox checkbox-primary rounded ml-1 w-5 h-5 ease-linear transition-all duration-150 border border-gray-200 focus:bg-white focus:border-gray-500 form-check-input" type="checkbox" name="permissions" <?= isset($matrix[$permission]) ? 'checked="checked"' : '' ?>  <?= $alias == 'superadmin' ? 'disabled checked="checked' : '' ?> value="<?= $permission ?>" hx-put="<?= route_to('group-permissions-toggle-only', $permission); ?>" hx-include="[name='type']" hx-target="closest .list-group-item" hx-trigger="click" hx-swap="outerHTML">
        </label>
    </td>
    <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200"><?= $permission ?></td>
    <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-3 dark:text-gray-200"><?= $description ?></td>
</tr>