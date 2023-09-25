<?php

namespace Btw\Core\Controllers;

use Btw\Blog\Libraries\GitHub;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class FrontController extends BaseController
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * @var GitHub
     */
    protected $github;

    protected $lang;

    protected $twig;

    /**
     * The theme to use.
     *
     * @var string
     */
    protected $theme = 'App';

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = array_merge($this->helpers, ['assets', 'setting', 'form']);
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);


        $config = [
            'paths' => [ROOTPATH . 'themes/App', APPPATH  . 'Modules/btw-front/src/Views/Front'],
            'cache' => WRITEPATH . '/cache/twig',
            'debug' => true,
            'functions'      => [
                'asset_link',
                'theme_link',
                'setting',
                'form',
                'vite_url',
                'csrf_meta',
                'current_url'
            ]
        ];

        // print_r(theme()->path($this->theme));
        // exit;



        $this->twig = new \Btw\Core\Libraries\Twig($config);


        $this->github = service('github');

        $this->lang = service('language')->getLocale();
    }

    /**
     * Helper method to ensure we always have the info
     * we need on every page.
     */
    protected function render(string $view, array $data = [], ?array $options = null)
    {

        $viewMeta         = service('viewMeta');
        $data['viewMeta'] = $viewMeta;

        $this->response->noCache();
        // Prevent some security threats, per Kevin
        // Turn on IE8-IE9 XSS prevention tools
        $this->response->setHeader('X-XSS-Protection', '1; mode=block');
        // Don't allow any pages to be framed - Defends against CSRF
        $this->response->setHeader('X-Frame-Options', 'DENY');
        // prevent mime based attacks
        $this->response->setHeader('X-Content-Type-Options', 'nosniff');

        return view($view, $data);
    }
}
