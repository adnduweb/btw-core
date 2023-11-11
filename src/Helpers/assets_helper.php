<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
if (!defined('asset_link')) {
    /**
     * Generates the URL to serve an asset to the client
     *
     * @param string $type css, js
     */
    function asset_link(string $location, string $type, array $options = []): string
    {
        $url = asset($location, $type);

        $tag = '';
        $defer = ' ';

        if (!empty($options)) {
            foreach ($options as $option) {
                if ($option == 'defer') {
                    $defer = ' defer ';
                }
            }
        }

        switch ($type) {
            case 'css':
                $tag = "<link href='{$url}' rel='stylesheet' />";
                break;

            case 'js':
                $tag = "<script{$defer}src='{$url}'></script>";
        }

        return $tag . "\n";
    }
}

if (!defined('asset_url')) {
    function asset_url(string $location, string $type): string
    {
        $url = asset($location, $type);
        return $url;
    }
}

if (!defined('asset')) {
    function asset(string $location, string $type): string
    {
        $config   = config('Assets');
        $location = trim($location, ' /');

        // Add a cache-busting fingerprint to the filename
        $segments = explode('/', $location);
        $filename = array_pop($segments);
        $ext      = substr($filename, strrpos($filename, '.'));

        if (empty($filename) || empty($ext) || $filename === $ext || empty($segments)) {
            throw new \RuntimeException('You must provide a valid filename and extension to the asset() helper.');
        }

        // VERSION cache-busting
        $fingerprint = '';
        if ($config->bustingType === 'version') {
            switch (ENVIRONMENT) {
                case 'testing':
                case 'development':
                    $fingerprint = time();
                    break;

                default:
                    $fingerprint = $config->versions[$type];
            }
        }
        // FILE cache-busting
        if ($config->bustingType === 'file') {
            $tempSegments = $segments;
            array_shift($tempSegments);
            $path = rtrim($config->folders[current($segments)], ' /') . '/' . implode(
                '/',
                $tempSegments
            ) . '/' . $filename;

            $fingerprint = filemtime($path);

            if ($fingerprint === false) {
                throw new \RuntimeException('Unable to get modification time of asset file: ' . $filename);
            }
        }

        $filename = str_replace($ext, '.' . $fingerprint . $ext, $filename);

        // Stitch the location back together
        $segments[] = $filename;
        $location   = implode('/', $segments);
        $url        = "/assets/{$location}";

        return base_url($url);
    }
}

if (!defined('theme_link')) {
    /**
     * Generates the URL to serve an asset to the client
     *
     * @param string $type css, js
     */
    function theme_link(string $location, string $type): string
    {
        $url = theme_locate($location, $type);

        $tag = '';

        switch ($type) {
            case 'css':
                $tag = "<link href='{$url}' rel='stylesheet' />";
                break;

            case 'js':
                $tag = "<script src='{$url}'></script>";
        }

        return $tag;
    }
}

if (!defined('theme_locate')) {
    function theme_locate(string $location, string $type): string
    {
        $config   = config('Assets');
        $location = trim($location, ' /');

        // Add a cache-busting fingerprint to the filename
        $segments = explode('/', $location);
        $filename = array_pop($segments);
        $ext      = substr($filename, strrpos($filename, '.'));

        if (empty($filename) || empty($ext) || $filename === $ext || empty($segments)) {
            throw new \RuntimeException('You must provide a valid filename and extension to the asset() helper.');
        }

        // VERSION cache-busting
        $fingerprint = '';
        if ($config->bustingType === 'version') {
            switch (ENVIRONMENT) {
                case 'testing':
                case 'development':
                    $fingerprint = time();
                    break;

                default:
                    $fingerprint = $config->versions[$type];
            }
        }
        // FILE cache-busting
        if ($config->bustingType === 'file') {
            $tempSegments = $segments;
            array_shift($tempSegments);
            $path = rtrim($config->folders[current($segments)], ' /') . '/' . implode(
                '/',
                $tempSegments
            ) . '/' . $filename;

            $fingerprint = filemtime($path);

            if ($fingerprint === false) {
                throw new \RuntimeException('Unable to get modification time of asset file: ' . $filename);
            }
        }

        //$filename = str_replace($ext, '.' . $fingerprint . $ext, $filename);

        // Stitch the location back together
        $segments[] = $filename;
        $location   = implode('/', $segments);
        $url        = "/themes/{$location}";

        return base_url($url);
    }
}
