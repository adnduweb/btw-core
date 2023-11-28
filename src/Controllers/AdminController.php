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
    protected $displayNotices;
    // protected $notifications;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = array_merge($this->helpers, ['alertHtmx', 'auth', 'setting', 'form', 'assets']);
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->addMeta();
        $this->langueCurrent = service('settings')->get('Btw.language_bo', 'user:' . Auth()->user()->id) ?? 'fr';
        service('language')->setLocale($this->langueCurrent);
        setlocale(LC_TIME, service('request')->getLocale() . '_' . service('request')->getLocale());

        // Notices
        $this->displayNotices = service('Notices')->instanceAll()->getDisplay();
        // print_r(service('Notices')->instanceAll()->getDisplay());
        // exit;

        // $this->notifications = service('notifications')->get(5);
    }

    protected function _getController()
    {
        $controllerName = service('router')->controllerName();
        $handle = explode('\\', $controllerName);
        $end = end($handle);
        $this->_controller = strtolower(str_replace('Controller', '', $end));
        return $this->_controller;
    }

    protected function _getMethod(string $url, int $code = 0)
    {

        $this->_method = service('router')->methodName();
        return $this->_method;
    }

    private function addMeta()
    {
        $viewMeta =  service('viewMeta');
        $viewMeta->addMeta(['name' => 'robots', 'content' => 'nofollow, noindex' ]);
        $viewMeta->addFavicon('admin');
        //$viewMeta->addScript(['src' => asset_url('admin/js/livewire.js', 'js'), 'data-csrf' => csrf_hash(), 'data-update-uri' => current_url(true)]);
        // $viewMeta->addScript(['src' => 'https://example.com/js/jquery.min.js', 'data-csrf' => csrf_hash(), 'data-update-uri' => current_url(true)]);


    }
}
