<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<ul class="inline-flex -space-x-px pagination m-0 ms-auto">
    <?php if ($pager->hasPreviousPage()) : ?>
        <li class="page-item">
            <a class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white page-link" href="<?= $pager->getFirst() ?>" hx-get="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
                <?= lang('Pager.first') ?>
            </a>
        </li>
        <li class="page-item">
            <a class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white page-link" href="<?= $pager->getPreviousPage() ?>" hx-get="<?= $pager->getPreviousPage() ?>" aria-label="<?= lang('Pager.previous') ?>">
                <?= lang('Pager.previous') ?>
            </a>
        </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <?php if ($link['active']) : ?>
            <li <?= $link['active'] ? 'class="page-item active"' : 'class="page-item"' ?>>
                <a class="px-3 py-2 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white page-link" href="<?= $link['uri'] ?>" hx-get="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php else : ?>
            <li class="page-item">
                <a class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white page-link" href="<?= $link['uri'] ?>" hx-get="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endif ?>

    <?php endforeach ?>

    <?php if ($pager->hasNextPage()) : ?>
        <li class="page-item">
            <a class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white page-link" href="<?= $pager->getNextPage() ?>" hx-get="<?= $pager->getNextPage() ?>" aria-label="<?= lang('Pager.next') ?>">
                <?= lang('Pager.next') ?>
            </a>
        </li>
        <li class="page-item">
            <a class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white page-link page-link" href="<?= $pager->getLast() ?>" hx-get="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
                <?= lang('Pager.last') ?>
            </a>
        </li>
    <?php endif ?>
</ul>