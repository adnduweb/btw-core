<?php

namespace Btw\Core\Controllers;

use CodeIgniter\HTTP\CLIRequest;
use Btw\Core\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AdminController extends BaseController
{
    /**
     * The theme to use.
     *
     * @var string
     */
    protected $theme = 'admin';
    protected $langueCurrent;
    protected $_controller;
    protected $_method;
    protected $sessionAskAuth;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = array_merge($this->helpers, ['alertHtmx', 'auth', 'setting', 'form']);
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $viewMeta =  service('viewMeta');

        //setting('App.themebo', $this->theme);

        $viewMeta->addMeta(['name' => 'robots', 'content' => 'nofollow, noindex' ]);
        $viewMeta->addStyle(['rel' => 'apple-touch-icon','sizes' => '57x57', 'href' => '/admin/favicon/apple-icon-57x57.png']);
        $viewMeta->addStyle(['rel' => 'apple-touch-icon','sizes' => '60x60', 'href' => '/admin/favicon/apple-icon-60x60.png']);
        $viewMeta->addStyle(['rel' => 'apple-touch-icon','sizes' => '72x72', 'href' => '/admin/favicon/apple-icon-72x72.png']);
        $viewMeta->addStyle(['rel' => 'apple-touch-icon','sizes' => '76x76', 'href' => '/admin/favicon/apple-icon-76x76.png']);
        $viewMeta->addStyle(['rel' => 'apple-touch-icon','sizes' => '114x114', 'href' => '/admin/favicon/apple-icon-114x114.png']);
        $viewMeta->addStyle(['rel' => 'apple-touch-icon','sizes' => '120x120', 'href' => '/admin/favicon/apple-icon-120x120.png']);
        $viewMeta->addStyle(['rel' => 'apple-touch-icon','sizes' => '144x144', 'href' => '/admin/favicon/apple-icon-144x144.png']);
        $viewMeta->addStyle(['rel' => 'apple-touch-icon','sizes' => '152x152', 'href' => '/admin/favicon/apple-icon-152x152.png']);
        $viewMeta->addStyle(['rel' => 'icon','sizes' => '180x180', 'href' => '/admin/favicon/apple-icon-180x180.png']);
        $viewMeta->addStyle(['rel' => 'icon','type' => 'image/png', 'sizes' => '192x192', 'href' => '/admin/favicon/android-icon-192x192.png']);
        $viewMeta->addStyle(['rel' => 'icon','type' => 'image/png', 'sizes' => '32x32', 'href' => '/admin/favicon/favicon-32x32.png']);
        $viewMeta->addStyle(['rel' => 'icon','type' => 'image/png', 'sizes' => '96x96', 'href' => '/admin/favicon/favicon-96x96.png']);
        $viewMeta->addStyle(['rel' => 'icon','type' => 'image/png', 'sizes' => '16x16', 'href' => '/admin/favicon/favicon-16x16.png']);
        $viewMeta->addStyle(['rel' => 'manifest', 'href' => '/admin/favicon/manifest.json']);
        $viewMeta->addMeta(['name' => "msapplication-TileColor", 'content' => '#ffffff']);
        $viewMeta->addMeta(['name' => "msapplication-TileImage", 'content' => '/admin/favicon/ms-icon-144x144.png']);
        $viewMeta->addMeta(['name' => "theme-color", 'content' => '#ffffff']);


        $this->langueCurrent = service('settings')->get('Btw.language_bo', 'user:' . Auth()->user()->id) ?? 'fr';
        service('language')->setLocale($this->langueCurrent);
        setlocale(LC_TIME, service('request')->getLocale() . '_' . service('request')->getLocale());
    }

    private function _getController()
    {
        $controllerName = service('router')->controllerName();
        $handle = explode('\\', $controllerName);
        $end = end($handle);
        $this->_controller = strtolower(str_replace('Controller', '', $end));
        return $this->_controller;
    }

    private function _getMethod(string $url, int $code = 0)
    {

        $this->_method = service('router')->methodName();
        return $this->_method;
    }
}
