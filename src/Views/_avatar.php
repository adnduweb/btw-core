<div class="<?= $class ?>" title="<?= $user->name() ?>">
    <?php if ($user->avatarLink() !== '') : ?>
        <img class="rounded-full" src="<?= $user->avatarLink($size) ?>" alt="<?= $user->name() ?>">
    <?php else : ?>
        <?= $idString ?>
    <?php endif ?>
</div>