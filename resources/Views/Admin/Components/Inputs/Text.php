<input 
type="<?= (isset($type)) ? $type : 'text'; ?>" 
name="<?= (isset($name)) ? str_replace(' ', '_', strtolower($name)) : ''; ?>"
id="<?= (isset($label)) ? str_replace(' ', '_', strtolower($label)) : ''; ?>" 
autocomplete="<?= (isset($type)) ? $type : 'text'; ?>" 
value="<?= esc(set_value(str_replace(' ', '_', strtolower($name)), $value ?? null), 'attr') ?>" 
class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />

<?php if (has_error( (isset($name)) ? str_replace(' ', '_', strtolower($name)) : '')) : ?>
    <p class="text-danger"><?= error( (isset($name)) ? str_replace(' ', '_', strtolower($name)) : '') ?></p>
<?php endif ?>

<?php if (isset($description) && $description != "false") : ?>
<p class="mt-2 text-sm text-gray-500">
   <?= $description; ?>
</p>
<?php endif; ?>