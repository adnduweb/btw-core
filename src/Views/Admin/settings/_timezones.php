<option value="">Select...</option>
<?php foreach ($options as $timezone => $name) : ?>
    <option value="<?= $timezone ?>" <?php if ($selectedTZ === $timezone): ?> selected <?php endif ?>>
        <?= (!is_array($name)) ? $name : '' ;  ?>
    </option>
<?php endforeach ?>
