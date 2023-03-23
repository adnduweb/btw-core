<span style="width: <?= $size ?>px; height: <?= $size ?>px; font-size: <?= $fontSize ?>px;" class="avatar w-8 h-8 rounded-full bg-gray-300 overflow-hidden" title="<?= $user->name() ?>">
    <?php if ($user->avatarLink() !== '') : ?>
        <img class=" <?= $class ?>" src="<?= $user->avatarLink($size) ?>" alt="<?= $user->name() ?>">
    <?php else : ?>
        <?= $idString ?>
    <?php endif ?>
</span>