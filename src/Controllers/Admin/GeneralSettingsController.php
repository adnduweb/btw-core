<?php

/**
 * This file is part of Btw\Core.
 *
 * (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Controllers\Admin;

use Btw\Core\Controllers\AdminController;
use CodeIgniter\API\ResponseTrait;
use Btw\Core\Adapters\RawJsonResponse;
use DateTimeZone;
use Btw\Core\Menus\MenuItem;

/**
 * General Site Settings
 */
class GeneralSettingsController extends AdminController
{

    use ResponseTrait;

    /**
     * The theme to use.
     *
     * @var string
     */
    protected $theme = 'Admin';

    protected $viewPrefix = 'Btw\Core\Views\Admin\settings\\';

    protected $rememberOptions = [
        '1 hour'   => 1 * HOUR,
        '4 hours'  => 4 * HOUR,
        '8 hours'  => 8 * HOUR,
        '25 hours' => 24 * HOUR,
        '1 week'   => 1 * WEEK,
        '2 weeks'  => 2 * WEEK,
        '3 weeks'  => 3 * WEEK,
        '1 month'  => 1 * MONTH,
        '2 months' => 2 * MONTH,
        '6 months' => 6 * MONTH,
        '1 year'   => 12 * MONTH,
    ];

    public function __construct()
    {
        self::setupMenus();
        $this->addMenuSidebar();
    }

    /**
     * Displays the site's general settings.
     */
    public function sectionGeneral()
    {
        if (!auth()->user()->can('admin.settings')) {
            return redirect()->to(ADMIN_AREA)->with('error', lang('Btw.notAuthorized'));
        }

        $timezoneAreas = [];

        foreach (timezone_identifiers_list() as $timezone) {
            if (strpos($timezone, '/') === false) {
                $timezoneAreas[] = $timezone;

                continue;
            }

            [$area, $zone] = explode('/', $timezone);
            if (!in_array($area, $timezoneAreas, true)) {
                $timezoneAreas[] = $area;
            }
        }

        $currentTZ     = setting('App.appTimezone');
        $currentTZArea = strpos($currentTZ, '/') === false
            ? $currentTZ
            : substr($currentTZ, 0, strpos($currentTZ, '/'));

        if (!$this->request->is('post')) {
            return $this->render($this->viewPrefix . 'settings_general', [
                'timezones'       => $timezoneAreas,
                'currentTZArea'   => $currentTZArea,
                'timezoneOptions' => $this->getTimezones($currentTZArea),
                'dateFormat'      => setting('App.dateFormat') ?: 'M j, Y',
                'timeFormat'      => setting('App.timeFormat') ?: 'g:i A',
                'menu' => service('menus')->menu('sidebar_on'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        switch ($this->request->getVar('section')) {
            case 'general':

                $requestJson = $this->request->getJSON(true);
                $validation = service('validation');

                $validation->setRules([
                    'siteName'   => 'required|string'
                ]);

                if (!$validation->run($requestJson)) {
                    return view('Btw\Core\Views\Admin\settings\cells\form_cell_general', [
                        'validation' => $validation
                    ]) . alert('danger', 'Form validation failed.');
                }

                setting('Site.siteName', $requestJson['siteName']);
                setting('Site.siteOnline', $requestJson['siteOnline'] ?? 0);
               
                return view('Btw\Core\Views\Admin\settings\cells\form_cell_general', []) . alert('success', lang('Btw.resourcesSaved', ['users']));

                break;
            case 'dateandtime':

                $requestJson = $this->request->getJSON(true);
                $validation = service('validation');

                $validation->setRules([
                    'timezone'   => 'required|string',
                    'dateFormat' => 'required|string',
                    'timeFormat' => 'required|string',
                ]);

                if (!$validation->run($requestJson)) {
                    return view('Btw\Core\Views\Admin\settings\cells\form_cell_dateandtime', [
                        'validation' => $validation
                    ]) . alert('danger', 'Form validation failed.');
                }

                setting('App.appTimezone', $requestJson['timezone']);
                setting('App.dateFormat', $requestJson['dateFormat']);
                setting('App.timeFormat', $requestJson['timeFormat']);

                $timezoneAreas = [];

                foreach (timezone_identifiers_list() as $timezone) {
                    if (strpos($timezone, '/') === false) {
                        $timezoneAreas[] = $timezone;

                        continue;
                    }

                    [$area, $zone] = explode('/', $timezone);
                    if (!in_array($area, $timezoneAreas, true)) {
                        $timezoneAreas[] = $area;
                    }
                }

                $currentTZ     = setting('App.appTimezone');
                $currentTZArea = strpos($currentTZ, '/') === false
                    ? $currentTZ
                    : substr($currentTZ, 0, strpos($currentTZ, '/'));


                return view('Btw\Core\Views\Admin\settings\cells\form_cell_dateandtime', [
                    'timezones'       => $timezoneAreas,
                    'currentTZArea'   => $currentTZArea,
                    'timezoneOptions' => $this->getTimezones($currentTZArea),
                    'dateFormat'      => setting('App.dateFormat') ?: 'M j, Y',
                    'timeFormat'      => setting('App.timeFormat') ?: 'g:i A',
                ]) . alert('success', lang('Btw.resourcesSaved', ['users']));

                break;


            default:
                alert('danger', lang('Btw.erreor', ['settings']));
        }
    }

    /**
     * AJAX method to list available timezones within
     * a single timezone area  (AMERICA, AFRICA, etc)
     */
    public function getTimezones(?string $area = null): string
    {
        $area = $area === null
            ? $this->request->getVar('timezoneArea')
            : $area;
        $ids = [
            'Africa'     => DateTimeZone::AFRICA,
            'America'    => DateTimeZone::AMERICA,
            'Antarctica' => DateTimeZone::ANTARCTICA,
            'Arctic'     => DateTimeZone::ARCTIC,
            'Asia'       => DateTimeZone::ASIA,
            'Atlantic'   => DateTimeZone::ATLANTIC,
            'Australia'  => DateTimeZone::AUSTRALIA,
            'Europe'     => DateTimeZone::EUROPE,
            'Indian'     => DateTimeZone::INDIAN,
            'Pacific'    => DateTimeZone::PACIFIC,
        ];

        $options = [];

        if ($area === 'UTC') {
            $options[] = ['UTC' => 'UTC'];
        } else {
            foreach (timezone_identifiers_list($ids[$area]) as $timezone) {
                $formattedTimezone  = str_replace('_', ' ', $timezone);
                $formattedTimezone  = str_replace($area . '/', '', $formattedTimezone);
                $options[$timezone] = $formattedTimezone;
            }
        }

        // print_r( $options); exit;

        return view($this->viewPrefix . '_timezones', [
            'options'    => $options,
            'selectedTZ' => setting('App.appTimezone'),
        ]);
    }

    /**
     * Displays the site's registration settings.
     */
    public function sectionRegistrationLogin()
    {

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_registration', [
                'rememberOptions' => $this->rememberOptions,
                'defaultGroup'    => setting('AuthGroups.defaultGroup'),
                'groups'          => setting('AuthGroups.groups'),
                'menu' => service('menus')->menu('sidebar_on'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }
        switch ($this->request->getVar('section')) {
            case 'registration':
                $requestJson = $this->request->getJSON(true);
                $validation = service('validation');

                $validation->setRules([
                    'defaultGroup'          => 'required|string',
                ]);

                if (!$validation->run($requestJson)) {
                    return view('Btw\Core\Views\Admin\settings\cells\form_cell_registration', [
                        'validation' => $validation
                    ]) . alert('danger', 'Form validation failed.');;
                }

                setting('Auth.allowRegistration', $requestJson['allowRegistration'] ?? false);
                Setting('AuthGroups.defaultGroup', $requestJson['defaultGroup']);

                // Actions
                $actions             = setting('Auth.actions');
                $actions['register'] = $requestJson['emailActivation'] ?? null;
                setting('Auth.actions', $actions);

                $this->response->triggerClientEvent('updateSettingsRegistration');

                return view('Btw\Core\Views\Admin\settings\cells\form_cell_registration', [
                    'groups' => setting('AuthGroups.groups'),
                    'defaultGroup'    => setting('AuthGroups.defaultGroup'),
                ]) . alert('success', lang('Btw.resourcesSaved', ['settings']));

                break;

            case 'login':

                $requestJson = $this->request->getJSON(true);

                // Remember Me
                $sessionConfig                     = setting('Auth.sessionConfig');
                $sessionConfig['allowRemembering'] = $requestJson['allowRemember'] ?? false;
                $sessionConfig['rememberLength']   = $requestJson['rememberLength'];
                setting('Auth.sessionConfig', $sessionConfig);

                // Actions
                $actions             = setting('Auth.actions');
                $actions['login']    = $requestJson['email2FA'] ?? null;
                setting('Auth.actions', $actions);

                return view('Btw\Core\Views\Admin\settings\cells\form_cell_login', [
                    'rememberOptions' => $this->rememberOptions,
                    'groups' => setting('AuthGroups.groups'),
                    'defaultGroup'    => setting('AuthGroups.defaultGroup'),
                ]) . alert('success', lang('Btw.resourcesSaved', ['users']));

                break;
            default:
                alert('danger', lang('Btw.erreor', ['settings']));
        }
    }


    /**
     * Displays the site's passwords settings.
     */
    public function sectionPasswords()
    {

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_passwords', [
                'menu' => service('menus')->menu('sidebar_on'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        $requestJson = $this->request->getJSON(true);
        $validation = service('validation');

        $validation->setRules([
            'minimumPasswordLength' => 'required|integer|greater_than[6]'
        ]);

        if (!$validation->run($requestJson)) {
            return view('Btw\Core\Views\Admin\users\form_cell_password', [
                'validation' => $validation
            ]) . alert('danger', 'Form validation failed.');;
        }

        setting('Auth.minimumPasswordLength', (int)$requestJson['minimumPasswordLength']);
        setting('Auth.passwordValidators', $requestJson['validators[]']);

        return view('Btw\Core\Views\Admin\settings\cells\form_cell_password', [
            'groups' => setting('AuthGroups.groups'),
            'defaultGroup'    => setting('AuthGroups.defaultGroup'),
        ]) . alert('success', lang('Btw.resourcesSaved', ['users']));
    }


    /**
     * Displays the site's passwords settings.
     */
    public function sectionAvatar()
    {

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_avatar', [
                'menu' => service('menus')->menu('sidebar_on'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }


        $requestJson = $this->request->getJSON(true);

        // Avatars
        setting('Users.useGravatar', $requestJson['useGravatar'] ?? false);
        setting('Users.gravatarDefault', $requestJson['gravatarDefault']);
        setting('Users.avatarNameBasis', $requestJson['avatarNameBasis']);

        $this->response->triggerClientEvent('updateAvatar', time(), 'receive');

        return view('Btw\Core\Views\Admin\settings\cells\form_cell_avatar', [
            'groups' => setting('AuthGroups.groups'),
            'defaultGroup'    => setting('AuthGroups.defaultGroup'),
        ]) . alert('success', lang('Btw.resourcesSaved', ['users']));
    }

    public function sectionEmail()
    {
        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_email', [
                'config'    => config('Email'),
                'activeTab' => setting('Email.protocol') ?? 'smtp',
                'menu' => service('menus')->menu('sidebar_on'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        $requestJson = $this->request->getJSON(true);
        $validation = service('validation');

        $validation->setRules([
            'fromName'      => 'required|string|min_length[2]',
            'fromEmail'     => 'required|valid_email',
            'protocol'      => 'required|in_list[mail,sendmail,smtp]',
            'mailPath'      => 'permit_empty|string',
            'SMTPHost'      => 'permit_empty|string',
            'SMTPPort'      => 'permit_empty|in_list[25,587,465,2525,other]',
            'SMTPPortOther' => 'permit_empty|string',
            'SMTPUser'      => 'permit_empty|string',
            'SMTPPass'      => 'permit_empty|string',
            'SMTPCrypto'    => 'permit_empty|in_list[ssl,tls]',
            'SMTPTimeout'   => 'permit_empty|integer|greater_than_equal_to[0]',
            'SMTPKeepAlive' => 'permit_empty|in_list[0,1]',
        ]);

        if (!$validation->run($requestJson)) {
            return view('Btw\Core\Views\Admin\settings\cells\form_cell_email', [
                'config'    => config('Email'),
                'activeTab' => setting('Email.protocol') ?? 'smtp',
                'validation' => $validation
            ]) . alert('danger', 'Form validation failed.');
        }

        $port = $requestJson['SMTPPort'] === 'other'
            ? $requestJson['SMTPPortOther']
            : $requestJson['SMTPPort'];

        setting('Email.fromName', $requestJson['fromName']);
        setting('Email.fromEmail', $requestJson['fromEmail']);
        setting('Email.protocol', $requestJson['protocol']);
        setting('Email.mailPath', $requestJson['mailPath']);
        setting('Email.SMTPHost', $requestJson['SMTPHost']);
        setting('Email.SMTPPort', $port);
        setting('Email.SMTPUser', $requestJson['SMTPUser']);
        setting('Email.SMTPPass', $requestJson['SMTPPass']);
        setting('Email.SMTPCrypto', $requestJson['SMTPCrypto']);
        setting('Email.SMTPTimeout', $requestJson['SMTPTimeout']);
        setting('Email.SMTPKeepAlive', $requestJson['SMTPKeepAlive']);

        return view('Btw\Core\Views\Admin\settings\cells\form_cell_email', [
            'config'    => config('Email'),
            'activeTab' => setting('Email.protocol') ?? 'smtp'
        ]) . alert('success', lang('Btw.resourcesSaved', ['users']));
    }

    /**
     * Creates any admin-required menus so they're
     * available to use by any modules.
     */
    private function setupMenus()
    {
        $menus = service('menus');

        // Sidebar menu
        $menus->createMenu('sidebar_on');
        $menus->menu('sidebar_on')
            ->createCollection('content', 'Content');
    }
    public function addMenuSidebar()
    {
        $sidebar = service('menus');
        $item    = new MenuItem([
            'title'           => 'Général',
            'namedRoute'      => 'settings-general',
            'fontIconSvg'     => theme()->getSVG('duotune/abstract/abs029.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 1
        ]);
        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Login & Registration',
            'namedRoute'      => 'settings-registration',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen048.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 2
        ]);
        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Passwords',
            'namedRoute'      => 'settings-passwords',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen047.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 3
        ]);
        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Avatar',
            'namedRoute'      => 'settings-avatar',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen065.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 4
        ]);
        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Email',
            'namedRoute'      => 'settings-email',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen016.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 5
        ]);
        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Update',
            'namedRoute'      => 'settings-update',
            'fontIconSvg'     => theme()->getSVG('duotune/coding/cod005.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 6
        ]);

        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);
    }
}
