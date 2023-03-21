<?php

namespace Btw\Core\View;

use RuntimeException;

class Javascriptdata
{
    private array $base       = [];

    protected $token;

    public function __construct()
    {
        helper('setting');

        $this->token = getAdminToken(service('router')->controllerName() . (isset(Auth()->user()->id) ?? null) . (isset(Auth()->user()->last_login_at) ?? null));

        $this->base[] = ['base_url' => site_url(),];
        $this->base[] = ['current_url'    => current_url()];
        $this->base[] = ['areaAdmin'    => env('app.areaAdmin')];        
        $this->base[] = ['uri'            => service('request')->getUri()->getPath()];
        $this->base[] = ['basePath'       => '\/'];
        $this->base[] = ['crsftoken'      => csrf_token()];
        $this->base[] = ['csrfHash'      => csrf_hash()];
        $this->base[] = ['env'      => ENVIRONMENT];
        $this->base[] = ['csrfHash'      => csrf_hash()];

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        if ($authenticator->loggedIn()) {

            foreach (Auth()->user()->getGroups() as $k => $v) {
                $id_group[$v] = $v;
            }

            $this->base[] = ['user_uuid' =>  Auth()->user()->id];
            $this->base[] = ['id_group' =>  json_encode($id_group)];
            $this->base[] = ['activer_multilangue' =>  service('settings')->get('App.language_bo', 'multilangue')];
            $this->base[] = ['tokenHashPage' =>  $this->token];
            $this->base[] = ['System' =>  json_encode(['sendMailAccountManager' => site_url(route_to('send-mail-account-manager')), 'ajax' => site_url(route_to('ajax'))])];
        }
    }

    /**
     * Renders out the html for the given base type,
     * i.e. 'base', 'title', 'link', 'script', 'rawScript', 'style'.
     */
    public function render(): string
    {
        //  print_r($this->base);
        $html = "";
        $output = "";
        $html .= ' var doudou = {';
        $html .= "\n\t\t";
        foreach ($this->base as $val) {
            foreach ($val as $k => $v) {
                // print_r($k);
                // exit;
                $html .= ' "' . $k . '" : ';
                if (preg_match('`\[(.+)\]`iU', $v)) {
                    $html .=  $v;
                } elseif (preg_match('#{#', $v)) {
                    $html .=  $v;
                } else {
                    $html .= "'" . $v . "'";
                }

                $html .= ', ' . "\n\t\t";
            }
        }
        $html .= '}';
        $output = "<script>";
        if (ENVIRONMENT == "development" || ENVIRONMENT == "testing") {
            $output .= $html;
        } else {
            $html2 = preg_replace("/\s+/", "", $html);
            $output .= str_replace( array( '<br>', '<br />', "\n", "\r", "vardoudou" ), array( '', '', '', '', 'var doudou' ), trim($html2));
        }

        $output .= '</script> ' . "\n\t\t";

        return $output;
    }

    /**
     * Renders out the html for the given base type,
     * i.e. 'base', 'title', 'link', 'script', 'rawScript', 'style'.
     */
    public function renderLangJson($segments)
    {
        $segments = explode('/', $segments);
        /**
         * De-bust the filename
         *
         * @var string
         */
        $filename     = array_pop($segments);
        $origFilename = $filename;
        $filename     = explode('.', $filename);

        // Must be at least a name and extension
        if (count($filename) < 2) {
            service('response')->setStatusCode(404);

            return;
        }

       // If we have a fingerprint...
       $filename = count($filename) === 3
       ? $filename[0] . '.' . $filename[2]
       : $origFilename;


        $folder = config('Assets')->folders[array_shift($segments)];
        $path   = $folder . '/' . implode('/', $segments) . '/' . $filename;

        if (!is_file($path)) {
            service('response')->setStatusCode(404);

            return;
        }
        return '<script type="text/javascript">var _LANG_ = ' . preg_replace("# {2,}#"," ",preg_replace("#(\r\n|\n\r|\n|\r)#"," ", @file_get_contents($path))) . ';</script>';
    }

    /**
     * Add a base tag to the page.
     * Can be used to add base tags like 'description', 'keywords', 'author', etc.
     * and also to add custom base tags.
     *
     * Example:
     * $this->addMeta(['description' => 'This is the description of the page']);
     * $this->addMeta(['property' => 'og:title', 'content' => 'This is the title of the page']);
     */
    public function addBase(array $content): self
    {
        $this->base[] = $content;

        return $this;
    }

    /**
     * Get all base tags.
     */
    public function base(): array
    {
        return $this->base;
    }
}
