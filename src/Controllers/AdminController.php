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
    protected $theme = 'Admin';
    protected $langueCurrent;
    protected $_controller;
    protected $_method;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = array_merge($this->helpers, ['alertHtmx', 'auth', 'setting', 'form']);
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //setting('App.themebo', $this->theme);

        $this->langueCurrent = service('settings')->get('Btw.language_bo', 'user:' . Auth()->user()->id) ?? 'fr';
        service('language')->setLocale($this->langueCurrent);
        setlocale(LC_TIME, service('request')->getLocale() . '_' .  service('request')->getLocale());

        $controllerName = service('router')->controllerName();
        $handle = explode('\\', $controllerName);$end = end($handle);
        $this->_controller = strtolower(str_replace('Controller', '', $end));
        $this->_method = service('router')->methodName();
    }
}
