<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\View;

/**
 * Class Theme
 *
 * Provides utility commands to work with themes.
 */
class Theme
{
    /**
     * @var string
     */
    protected static $defaultTheme = 'app';

    /**
     * @var string
     */
    protected static $currentTheme;

    /**
     * Holds theme info retrieved
     *
     * @var array
     */
    protected static $themeInfo;

    protected static $ignore_session = false;

    protected static $message;

    /**
     * Sets the active theme.
     */
    public static function setTheme(string $theme)
    {
        static::$currentTheme = $theme;
    }

    /**
     * Returns the path to the specified theme folder.
     * If no theme is provided, will use the current theme.
     */
    public static function path(?string $theme = null): string
    {
        if (empty($theme)) {
            $theme = static::current();
        }

        // Ensure we've pulled the theme info
        if (empty(static::$themeInfo)) {
            static::$themeInfo = self::available();
        }

        foreach (static::$themeInfo as $info) {
            if ($info['name'] === $theme) {
                return $info['path'];
            }
        }

        return '';
    }

    /**
     * Returns the name of the active theme.
     *
     * @return string
     */
    public static function current()
    {
        return !empty(static::$currentTheme)
            ? static::$currentTheme
            : static::$defaultTheme;
    }

    /**
     * Returns an array of all available themes
     * and the paths to their directories.
     */
    public static function available(): array
    {
        $themes = [];
        helper('filesystem');

        foreach (config('Themes')->collections as $collection) {
            $info = get_dir_file_info($collection, true);

            if (!count($info)) {
                continue;
            }

            foreach ($info as $name => $row) {
                $themes[] = [
                    'name'          => $name,
                    'path'          => $row['relative_path'] . $name . '/',
                    'hasComponents' => is_dir($row['relative_path'] . $name . '/Components'),
                ];
            }
        }

        return $themes;
    }

    public static function getSVG($path, $class = '', $svgClass = '', $javascript = false)
    {
        $path = str_replace('\\', '/', trim($path));
        $full_path = $path;
        if (!file_exists($path)) {
            $full_path = config('Themes')->collectionsMedias . $path;

            // print_r($full_path); exit;

            if (!is_string($full_path)) {
                return '';
            }

            if (!file_exists($full_path)) {
                return "<!--SVG file not found: $path-->\n";
            }
        }

        $svg_content = @file_get_contents($full_path);
        if (!$svg_content) {
            return '';
        }

        $dom = new \DOMDocument();
        $dom->loadXML($svg_content);

        // remove unwanted comments
        $xpath = new \DOMXPath($dom);
        foreach ($xpath->query('//comment()') as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        // add class to svg
        if (!empty($svgClass)) {
            foreach ($dom->getElementsByTagName('svg') as $element) {
                $element->setAttribute('class', $svgClass);
            }
        }

        // remove unwanted tags
        $title = $dom->getElementsByTagName('title');
        if ($title['length']) {
            $dom->documentElement->removeChild($title[0]);
        }
        $desc = $dom->getElementsByTagName('desc');
        if ($desc['length']) {
            $dom->documentElement->removeChild($desc[0]);
        }
        $defs = $dom->getElementsByTagName('defs');
        if ($defs['length']) {
            $dom->documentElement->removeChild($defs[0]);
        }

        // remove unwanted id attribute in g tag
        $g = $dom->getElementsByTagName('g');
        foreach ($g as $el) {
            $el->removeAttribute('id');
        }
        $mask = $dom->getElementsByTagName('mask');
        foreach ($mask as $el) {
            $el->removeAttribute('id');
        }
        $rect = $dom->getElementsByTagName('rect');
        foreach ($rect as $el) {
            $el->removeAttribute('id');
        }
        $xpath = $dom->getElementsByTagName('path');
        foreach ($xpath as $el) {
            $el->removeAttribute('id');
        }
        $circle = $dom->getElementsByTagName('circle');
        foreach ($circle as $el) {
            $el->removeAttribute('id');
        }
        $use = $dom->getElementsByTagName('use');
        foreach ($use as $el) {
            $el->removeAttribute('id');
        }
        $polygon = $dom->getElementsByTagName('polygon');
        foreach ($polygon as $el) {
            $el->removeAttribute('id');
        }
        $ellipse = $dom->getElementsByTagName('ellipse');
        foreach ($ellipse as $el) {
            $el->removeAttribute('id');
        }

        $string = $dom->saveXML($dom->documentElement);

        // remove empty lines
        $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

        $cls = array('svg-icon');

        if (!empty($class)) {
            $cls = array_merge($cls, explode(' ', $class));
        }

        $asd = explode('/media/', $path);
        if (isset($asd[1])) {
            $path = 'assets/media/' . $asd[1];
        }

        $output  = "<!--begin::Svg Icon | path: $path-->\n";
        $output .= '<span class="' . implode(' ', $cls) . '">' . $string . '</span>';
        $output .= "\n<!--end::Svg Icon-->";

        if ($javascript == true) {
            $search = array(
                '/(\n|^)(\x20+|\t)/',
                '/(\n|^)\/\/(.*?)(\n|$)/',
                '/\n/',
                '/\<\!--.*?-->/',
                '/(\x20+|\t)/', # Delete multispace (Without \n)
                '/\>\s+\</', # strip whitespaces between tags
                '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
                '/=\s+(\"|\')/'
            ); # strip whitespaces between = "'

            $replace = array(
                "\n",
                "\n",
                " ",
                "",
                " ",
                "><",
                "$1>",
                "=$1"
            );
            $html = preg_replace($search, $replace, $output);
            return $html;
        }


        return $output;
    }

    public static function set_message_htmx($type = 'info', $message = '', $title = 'info')
    {
        if (empty($message)) {
            return;
        }
        $session = \Config\Services::session();

        if (!self::$ignore_session && isset($session)) {
            //echo serialize($message); exit;
            $message = serialize($message);
            $session->setFlashdata('messageHTMX', "{$type}::{$message}::{$title}");
        }

        self::$message = array(
            'type' => $type,
            'message' => $message,
            'title' => $title
        );
    }

    public static function set_message_not_htmx($type = 'info', $message = '', $title = 'info')
    {
        if (empty($message)) {
            return;
        }
        $session = \Config\Services::session();

        if (!self::$ignore_session && isset($session)) {
            //echo serialize($message); exit;
            $message = serialize($message);
            $session->setFlashdata('messageNotHTMX', "{$type}::{$message}::{$title}");
        }

        self::$message = array(
            'type' => $type,
            'message' => $message,
            'title' => $title
        );
    }

    

}
