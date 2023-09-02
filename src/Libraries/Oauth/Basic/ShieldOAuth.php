<?php

declare(strict_types=1);

/**
 * This file is part of Shield OAuth.
 *
 * (c) Datamweb <pooya_parsa_dadashi@yahoo.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Libraries\Oauth\Basic;

use CodeIgniter\Config\Factories;
use CodeIgniter\Files\FileCollection;

class ShieldOAuth
{
    public static function setOAuth(string $serviceName): object
    {
        $serviceName = ucfirst($serviceName);
        $className   = '\Btw\Core\Libraries\Oauth\\' . $serviceName . 'OAuth';

        // For to detect custom OAuth
        if (file_exists(APPPATH . 'Libraries/ShieldOAuth' . DIRECTORY_SEPARATOR . $serviceName . 'OAuth.php')) {
            $className = 'App\Libraries\ShieldOAuth\\' . $serviceName . 'OAuth';
        }

        return $oauthClass = Factories::loadOAuth($className);
    }

    /**
     * --------------------------------------------------------------------
     * Names of all supported services
     * --------------------------------------------------------------------
     * Here we have recorded the list of all the services with which it is possible to login.
     *
     * Returns the names of all supported services for use in routes
     * e.g. 'github|google|yahoo|...'
     * Note: @see https://codeigniter.com/user_guide/incoming/routing.html#custom-placeholders
     */
    public function allOAuth(): string
    {
        $files = new FileCollection();

        // Adds all Libraries files if install via composer
        $files = $files->add(VENDORPATH . 'adnduweb/btw-core/src/Libraries/Oauth', false);

        // show only all *OAuth.php files
        $files = $files->retainPattern('*OAuth.php');

        $allAllowedRoutes = '';

        foreach ($files as $file) {
            // make string github|google and ... from class name
            $allAllowedRoutes .= strtolower(str_replace($search = 'OAuth.php', $replace = '|', $subject = $file->getBasename()));
        }

        return mb_substr($allAllowedRoutes, 0, -1);
    }

    private function otherOAuth(): array
    {
        $pieces = explode('|', $this->allOAuth());

        return array_diff($pieces, ['github', 'google']);
    }

    public function makeOAuthButton(string $forPage = 'login'): string
    {
        $Button = '';
        $current = (string)current_url(true);

        $active_by = lang('ShieldOAuthLang.login_by');
        if ($forPage === 'register') {
            $active_by = lang('ShieldOAuthLang.register_by');
        }

        //On regarde si on est autorisé à se connecter Login en Oauth
        if (in_array((string)$current, [route_to('login')])) {
            if (service('settings')->get('ShieldOAuthConfig.allow_login') == false) {
                return $Button;
            }
        }


        //On regarde si on est autorisé à se connecter register en Oauth
        if (in_array((string)$current, [route_to('register')])) {
            if (service('settings')->get('ShieldOAuthConfig.allow_register') == false) {
                return $Button;
            }
        }

        // $googleOauth = servicse('settings')->set()->set('ShieldOAuthConfig.google-allow_login');

        $Button = "<div class='mt-6 grid grid-cols-3 items-center text-gray-400'>
            <hr class='border-gray-400'>
            <p class='text-center text-sm'>OR</p>
            <hr class='border-gray-400'>
        </div>
        <div class='text-center'>
                 <div class='btn-group' role='group' aria-label='Button group with nested dropdown'>
                 <a href='#' class='btn btn-primary active' aria-current='page'>" . $active_by . '</a>';
        if (service('settings')->get('ShieldOAuthConfig.allow_login_google') == true) {
            $Button .= '<a href=' . base_url('oauth/google') . " class='bg-white border py-2 w-full rounded-xl mt-5 flex justify-center items-center text-sm hover:scale-105 duration-300 text-[#002D74]' aria-current='page'>
        <svg class='mr-3' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 48 48' width='25px'>
          <path fill='#FFC107' d='M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z' />
          <path fill='#FF3D00' d='M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z' />
          <path fill='#4CAF50' d='M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z' />
          <path fill='#1976D2' d='M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z' />
        </svg>
        " . lang('ShieldOAuthLang.Google.google') . '</a>';
        }
        if (service('settings')->get('ShieldOAuthConfig.allow_login_github') == true) {
            $Button .= '<a href=' . base_url('oauth/github') . " class='bg-white border py-2 w-full rounded-xl mt-5 flex justify-center items-center text-sm hover:scale-105 duration-300 text-[#002D74]' aria-current='page'>
        <svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' class='w-5 mr-3 text-gray-700' viewBox='0 0 16 16'>
<path d='M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z'/>
                                </svg>
                                " . lang('ShieldOAuthLang.Github.github') . '</a>';
        }

        $Button .= '
        </div>
        </div>';

        // echo $Button;exit;

        return $Button;
    }
}
