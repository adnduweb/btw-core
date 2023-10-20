<?php

use Config\Services;
use CodeIgniter\CodeIgniter;

helper('assets');

$errorId = uniqid('error', true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= csrf_meta() ?>
    <title>Forbidden</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <?= service('viewJavascript')->renderLangJson('admin/js/lang/' . service('request')->getLocale() . '.json'); ?>
    <?= vite_tags(['themes/admin/css/app.css', 'themes/admin/js/app.js'], 'admin') ?>
</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <?php if (ENVIRONMENT == 'production') : ?>
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                    <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                        404 </div>

                    <div class="flex ml-4 text-lg text-gray-500 uppercase tracking-wider">
                        <?= nl2br(esc($message)) ?>
                    </div>

                </div>
                <div class="flex items-center justify-center ml-4 mt-5 text-lg text-gray-500 uppercase tracking-wider">
                    <a href="/<?= ADMIN_AREA; ?>" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"> return Home</a>
                </div>
            </div>
        <?php else : ?>
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center pt-8 sm:justify-start sm:pt-0">

                    <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                        <!-- Header -->
                        <div class="header">
                            <div class="container">
                                
                                <h1>
                                    <?= esc($title), esc($exception->getCode() ? ' #' . $exception->getCode() : '') ?>
                                </h1>

                                <p>
                                    <?= nl2br(esc($exception->getMessage())) ?>
                                    <a href="https://www.duckduckgo.com/?q=<?= urlencode($title . ' ' . preg_replace('#\'.*\'|".*"#Us', '', $exception->getMessage())) ?>" rel="noreferrer" target="_blank">search &rarr;</a>
                                </p>
                            </div>
                        </div>

                        <div class="container">
                            <p><b><?= esc(clean_path($file)) ?></b> at line <b><?= esc($line) ?></b></p>

                            <?php if (is_file($file)) : ?>
                                <div class="source">
                                    <?= static::highlightFile($file, $line, 15); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="footer">
                            <div class="container">

                                <p>
                                    Displayed at <?= esc(date('H:i:sa')) ?> &mdash;
                                    PHP: <?= esc(PHP_VERSION) ?> &mdash;
                                    CodeIgniter: <?= esc(CodeIgniter::CI_VERSION) ?>
                                </p>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>

    <?= service('viewJavascript')->render(); ?>
    <?= asset_link('admin/js/moment.min.js', 'js') ?>
    <?= asset_link('admin/js/moment-with-locales.min.js', 'js') ?>

</body>

</html>