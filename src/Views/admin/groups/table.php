<?php if (empty($groups)) : ?>
    <div class="card-body">
        <div class="empty">
            <p class="empty-title">No groups</p>
            <p class="empty-subtitle text-muted">
                No groups found :(
            </p>
        </div>
    </div>
<?php else : ?>
    <div x-data="listen" class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <thead>
                <tr class="text-left" hx-include="closest .card" hx-swap="morph:outerHTML" hx-target="closest .card">
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">Title</th>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">Description</th>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">Alias</th>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">Nb. de compte </th>
                    <th class="bg-indigo-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs"></th>
                </tr>
            </thead>
            <tbody id="books-table-rows">
                <?php foreach ($groups as $group) : ?>
                    <?= $this->setVar('group', $group)->include('Btw\Core\Views\admin\groups\table_row'); ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>