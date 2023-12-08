<?php

namespace Btw\Core\View;

use RuntimeException;

class Metadata
{
    private string $title     = '';
    private array $meta       = [];
    private array $favicon       = [];
    private array $link       = [];
    private array $script     = [];
    private array $rawScripts = [];
    private array $style      = [];

    public function __construct()
    {
        helper('setting');

        $this->title  = setting('Site.siteName') ?? '';
        $this->meta[] = ['charset' => 'UTF-8'];
        $this->meta[] = ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no'];
    }

    /**
     * Renders out the html for the given meta type,
     * i.e. 'meta', 'title', 'link', 'script', 'rawScript', 'style'.
     */
    public function render(string $type): string
    {
        if (!isset($this->{$type})) {
            throw new RuntimeException('Metadata type not found');
        }

        if ($type === 'title') {
            return '<title>' . $this->title . '</title>';
        }

        $html = '';

        if ($type === 'rawScripts') {
            foreach ($this->rawScripts as $script) {
                $html .= '<script>' . $script . '</script>';
            }

            return $html;
        }

        $content = $this->{$type};
        if ($type === 'style') {
            $type = 'link';
        }

        foreach ($content as $item) {
            $html .= '<' . $type . ' ';

            foreach ($item as $key => $value) {
                if($value == 'defer') {
                    $html .= $value . ' ';
                } else {
                    $html .= $key . '="' . $value . '" ';
                }

            }

            $html .= '>';

            if ($type === 'script') {
                $html .= '</script>';
            }

            $html .= "\n";
        }

        return $html;
    }

    /**
     * Set the title of the page.
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the page title
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * Add a meta tag to the page.
     * Can be used to add meta tags like 'description', 'keywords', 'author', etc.
     * and also to add custom meta tags.
     *
     * Example:
     * $this->addMeta(['description' => 'This is the description of the page']);
     * $this->addMeta(['property' => 'og:title', 'content' => 'This is the title of the page']);
     */
    public function addMeta(array $content): self
    {
        $this->meta[] = $content;

        return $this;
    }

    /**
     * Get all meta tags.
     */
    public function meta(): array
    {
        return $this->meta;
    }

    /**
     * Add a link tag to the page.
     * Can be used to add link tags like 'canonical', 'prev', 'next', etc.
     * and also to add custom link tags.
     *
     * Example:
     * $this->addLink(['rel' => 'canonical', 'href' => 'https://example.com/']);
     * $this->addLink(['rel' => 'icon', 'href' => 'favicon.ico', 'type' => 'image/x-icon']);
     */
    public function addLink(array $content): self
    {
        $this->link[] = $content;

        return $this;
    }

    /**
     * Get all link tags.
     */
    public function links(): array
    {
        return $this->link;
    }

    /**
     * Add a script tag to the page.
     * Can be used to add script tags like 'jquery', 'bootstrap', etc.
     * and also to add custom script tags.
     *
     * Example:
     * $this->addScript(['src' => 'https://example.com/js/jquery.min.js']);
     * $this->addScript(['src' => 'https://example.com/js/bootstrap.min.js', 'type' => 'text/javascript']);
     */
    public function addScript(array $content): self
    {
        $this->script[] = $content;

        return $this;
    }

    /**
     * Get all script tags.
     */
    public function scripts(): array
    {
        return $this->script;
    }

    public function addRawScript(string $content): self
    {
        $this->rawScripts[] = $content;

        return $this;
    }

    /**
     * Get all raw script content.
     */
    public function rawScripts(): array
    {
        return $this->rawScripts;
    }

    /**
     * Add a style tag to the page.
     * Can be used to add style tags like 'bootstrap', etc.
     * and also to add custom style tags.
     *
     * Example:
     * $this->addStyle(['href' => 'https://example.com/css/bootstrap.min.css']);
     * $this->addStyle(['href' => 'https://example.com/css/style.css', 'type' => 'text/css']);
     */
    public function addStyle(array $content): self
    {
        $this->style[] = $content;

        return $this;
    }

    /**
     * Get all style tags.
     */
    public function styles(): array
    {
        return $this->style;
    }

    public function addFavicon(string $theme)
    {
        $this->addStyle(['rel' => 'apple-touch-icon','sizes' => '512x512', 'href' => '/' . $theme . '/favicon/android-chrome-512x512']);
        $this->addStyle(['rel' => 'apple-touch-icon','sizes' => '192x192', 'href' => '/' . $theme . '/favicon/android-chrome-192x192']);
        $this->addStyle(['rel' => 'icon', 'type' => 'image/png', 'sizes' => '32x32', 'href' => '/' . $theme . '/favicon/favicon-32x32.png']);
        $this->addStyle(['rel' => 'icon', 'type' => 'image/png', 'sizes' => '16x16', 'href' => '/' . $theme . '/favicon/favicon-16x16.png']);
        $this->addStyle(['rel' => 'apple-touch-icon','sizes' => '180x180', 'href' => '/' . $theme . '/favicon/apple-touch-icon.png']);
        $this->addStyle(['rel' => 'manifest', 'href' => '/' . $theme . '/favicon/site.webmanifest']);


        // $this->addStyle(['rel' => 'apple-touch-icon','sizes' => '57x57', 'href' => '/' . $theme . '/favicon/apple-icon-57x57.png']);
        // $this->addStyle(['rel' => 'apple-touch-icon','sizes' => '60x60', 'href' => '/' . $theme . '/favicon/apple-icon-60x60.png']);
        // $this->addStyle(['rel' => 'apple-touch-icon','sizes' => '72x72', 'href' => '/' . $theme . '/favicon/apple-icon-72x72.png']);
        // $this->addStyle(['rel' => 'apple-touch-icon','sizes' => '76x76', 'href' => '/' . $theme . '/favicon/apple-icon-76x76.png']);
        // $this->addStyle(['rel' => 'apple-touch-icon','sizes' => '114x114', 'href' => '/' . $theme . '/favicon/apple-icon-114x114.png']);
        // $this->addStyle(['rel' => 'apple-touch-icon','sizes' => '120x120', 'href' => '/' . $theme . '/favicon/apple-icon-120x120.png']);
        // $this->addStyle(['rel' => 'apple-touch-icon','sizes' => '144x144', 'href' => '/' . $theme . '/favicon/apple-icon-144x144.png']);
        // $this->addStyle(['rel' => 'apple-touch-icon','sizes' => '152x152', 'href' => '/' . $theme . '/favicon/apple-icon-152x152.png']);
        // $this->addStyle(['rel' => 'icon','sizes' => '180x180', 'href' => '/' . $theme . '/favicon/apple-icon-180x180.png']);
        // $this->addStyle(['rel' => 'icon','type' => 'image/png', 'sizes' => '192x192', 'href' => '/' . $theme . '/favicon/android-icon-192x192.png']);
        // $this->addStyle(['rel' => 'icon','type' => 'image/png', 'sizes' => '32x32', 'href' => '/' . $theme . '/favicon/favicon-32x32.png']);
        // $this->addStyle(['rel' => 'icon','type' => 'image/png', 'sizes' => '96x96', 'href' => '/' . $theme . '/favicon/favicon-96x96.png']);
        // $this->addStyle(['rel' => 'icon','type' => 'image/png', 'sizes' => '16x16', 'href' => '/' . $theme . '/favicon/favicon-16x16.png']);
        // $this->addStyle(['rel' => 'manifest', 'href' => '/' . $theme . '/favicon/manifest.json']);
        // $this->addMeta(['name' => "msapplication-TileColor", 'content' => '#ffffff']);
        // $this->addMeta(['name' => "msapplication-TileImage", 'content' => '/' . $theme . '/favicon/ms-icon-144x144.png']);
        // $this->addMeta(['name' => "theme-color", 'content' => '#ffffff']);
    }

}
