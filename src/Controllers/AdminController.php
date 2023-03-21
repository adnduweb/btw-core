<?php

namespace Btw\Core\Controllers;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
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

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = array_merge($this->helpers, ['alertHtmx', 'auth', 'setting', 'form']);
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        setting('App.themebo', $this->theme);
    }
}
