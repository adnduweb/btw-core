<div class="mt-1">
    <textarea 
    id="<?= (isset($name)) ? str_replace(' ', '_', strtolower($name)) : ''; ?>" 
    name="<?= (isset($name)) ? str_replace(' ', '_', strtolower($name)) : ''; ?>" 
    rows="3" 
    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" 
    placeholder="<?= (isset($placeholder)) ? $placeholder : ''; ?>"><?= (isset($value)) ? $value : ''; ?>
</textarea>
</div>

<?php if (isset($description) && $description != "false") : ?>
<p class="mt-2 text-sm text-gray-500">
   <?= $description; ?>
</p>
<?php endif; ?>