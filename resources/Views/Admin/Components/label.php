<label for="<?= (isset($for)) ? str_replace(' ', '_', strtolower($for)) : ''; ?>" class="block text-sm font-medium text-gray-700 mt-px pb-2 dark:text-gray-300"> <?= (isset($label)) ? ucfirst($label) : ''; ?> </label>