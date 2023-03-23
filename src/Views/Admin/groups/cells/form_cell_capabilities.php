<div id="capabilities" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6" x-data="{
	selectAll: false,
	toggleAllCheckboxes() {
		this.selectAll = !this.selectAll

		// GOOD uses bindings
        this.selectAll ? this.invoices = window.allInvoices :  this.invoices = [];

		// BAD This does not work, messes with the bindings
		checkboxes = document.querySelectorAll('.selectable');
		[...checkboxes].map((el) => {
			el.checked = this.selectAll;
		})
	}
}">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.Capabilities'); ?></h3>

        <table class="table table-striped border-collapse table-auto w-full whitespace-no-wrap  bg-white dark:bg-gray-800 table-striped relative" id="ckeck-list-checkbox">

            <thead>
                <tr class="relative dark:hover:bg-gray-600 hover:bg-slate-50 ">
                    <th class="text-left px-6 py-3">
                        <!--begin::Checkbox-->
                        <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                            <input @click="toggleAllCheckboxes()" x-bind:checked="selectAll"  class="form-check-input checkbox checkbox-primary rounded ml-1 w-5 h-5 ease-linear transition-all duration-150 border border-gray-200 focus:bg-white focus:border-gray-500" type="checkbox" value="" id="kt_select_all"  <?= $alias == 'superadmin' ? 'disabled checked="checked' : '' ?> hx-put="<?= route_to('group-permissions-toggle-all'); ?>" hx-include="[name='type']" hx-target="#permissions" hx-trigger="change" hx-swap="outerHTML" />
                            <span class="form-check-label" for="kt_select_all"><?= lang('Btw.Select all'); ?></span>
                        </label>
                        <!--end::Checkbox-->
                    </th>
                    <th></th>
                    <th></th>
                <tr>
            </thead>
            <?= $this->setVar('permissions', $permissions)->include('Btw\Core\Views\Admin\groups\cells\form_cell_capabilities_tr'); ?>
        </table>


    </div>
</div>