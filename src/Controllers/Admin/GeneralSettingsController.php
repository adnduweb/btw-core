<?php

/**
 * This file is part of Btw\Core.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Controllers\Admin;

use Btw\Core\Controllers\AdminController;
use CodeIgniter\API\ResponseTrait;
use DateTimeZone;
use Btw\Core\Libraries\Menus\MenuItem;

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
    protected $theme = 'admin';

    protected $viewPrefix = 'Btw\Core\Views\Admin\settings\\';

    protected $rememberOptions = [
        '1 hour' => 1 * HOUR,
        '4 hours' => 4 * HOUR,
        '8 hours' => 8 * HOUR,
        '25 hours' => 24 * HOUR,
        '1 week' => 1 * WEEK,
        '2 weeks' => 2 * WEEK,
        '3 weeks' => 3 * WEEK,
        '1 month' => 1 * MONTH,
        '2 months' => 2 * MONTH,
        '6 months' => 6 * MONTH,
        '1 year' => 12 * MONTH,
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
            if ($this->request->isHtmx()) {
                return $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.notAuthorized')]);
            } else {
                alertHtmx('danger', lang('Btw.message.notAuthorized'));
                return redirect()->to(ADMIN_AREA)->with('htmx:errorPermisssion', lang('Btw.message.notAuthorized'));
            }
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

        $currentTZ = setting('App.appTimezone');
        $currentTZArea = strpos($currentTZ, '/') === false
            ? $currentTZ
            : substr($currentTZ, 0, strpos($currentTZ, '/'));

        if (!$this->request->is('post')) {
            return $this->render($this->viewPrefix . 'settings_general', [
                'timezones' => $timezoneAreas,
                'currentTZArea' => $currentTZArea,
                'siteOnline' => setting('Site.siteOnline'),
                'timezoneOptions' => $this->getTimezones($currentTZArea),
                'dateFormat' => setting('App.dateFormat') ?: 'M j, Y',
                'timeFormat' => setting('App.timeFormat') ?: 'g:i A',
                'menu' => service('menus')->menu('sidebar_on'),
                'currentUrl' => request()->getUri()->getPath()
            ]);
        }

        switch ($this->request->getVar('section')) {
            case 'generalsetting':

                $data = $this->request->getPost();
                $validation = service('validation');

                $validation->setRules([
                    'siteName' => 'required|string'
                ]);

                if (!$validation->run($data)) {
                    $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.formValidationFailed', [lang('Btw.general.settings')])]);
                    $this->response->setReswap('innerHTML show:#information:top');
                    return view('Btw\Core\Views\Admin\settings\cells\form_cell_general', [
                        'validation' => $validation
                    ]);
                }

                setting('Site.siteName', $data['siteName']);
                setting('Btw.titleNameAdmin', $data['titleNameAdmin']);
                setting('Site.BreadcrumbStart', $data['BreadcrumbStart']);
                setting('Site.siteOnline', $data['siteOnline'] ?? 0);
                setting('Site.ipAllowed', trim($data['ipAllowed']) ?? '');
                setting('Site.activeMultilangue', $data['activeMultilangue'] ?? 0);



                $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.settings')])]);
                $this->response->setReswap('innerHTML show:#information:top');
                return view('Btw\Core\Views\Admin\settings\cells\form_cell_general', ['siteOnline' => setting('Site.siteOnline')]);

                break;
            case 'dateandtime':

                $data = $this->request->getPost();
                $validation = service('validation');

                $validation->setRules([
                    'timezone' => 'required|string',
                    'dateFormat' => 'required|string',
                    'timeFormat' => 'required|string',
                ]);

                if (!$validation->run($data)) {
                    $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.formValidationFailed', [lang('Btw.general.settings')])]);
                    return view('Btw\Core\Views\Admin\settings\cells\form_cell_dateandtime', [
                        'validation' => $validation
                    ]);
                }

                setting('App.appTimezone', $data['timezone']);
                setting('App.dateFormat', $data['dateFormat']);
                setting('App.timeFormat', $data['timeFormat']);

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

                $currentTZ = setting('App.appTimezone');
                $currentTZArea = strpos($currentTZ, '/') === false
                    ? $currentTZ
                    : substr($currentTZ, 0, strpos($currentTZ, '/'));

                $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.settings')])]);
                return view('Btw\Core\Views\Admin\settings\cells\form_cell_dateandtime', [
                    'timezones' => $timezoneAreas,
                    'currentTZArea' => $currentTZArea,
                    'timezoneOptions' => $this->getTimezones($currentTZArea),
                    'dateFormat' => setting('App.dateFormat') ?: 'M j, Y',
                    'timeFormat' => setting('App.timeFormat') ?: 'g:i A',
                ]);

                break;


            default:
                alertHtmx('danger', lang('Btw.erreor', ['settings']));
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
            'Africa' => DateTimeZone::AFRICA,
            'America' => DateTimeZone::AMERICA,
            'Antarctica' => DateTimeZone::ANTARCTICA,
            'Arctic' => DateTimeZone::ARCTIC,
            'Asia' => DateTimeZone::ASIA,
            'Atlantic' => DateTimeZone::ATLANTIC,
            'Australia' => DateTimeZone::AUSTRALIA,
            'Europe' => DateTimeZone::EUROPE,
            'Indian' => DateTimeZone::INDIAN,
            'Pacific' => DateTimeZone::PACIFIC,
        ];

        $options = [];

        if ($area === 'UTC') {
            $options[] = ['UTC' => 'UTC'];
        } else {
            foreach (timezone_identifiers_list($ids[$area]) as $timezone) {
                $formattedTimezone = str_replace('_', ' ', $timezone);
                $formattedTimezone = str_replace($area . '/', '', $formattedTimezone);
                $options[$timezone] = $formattedTimezone;
            }
        }

        // print_r( $options); exit;

        return view($this->viewPrefix . '_timezones', [
            'options' => $options,
            'selectedTZ' => setting('App.appTimezone'),
        ]);
    }

    /**
     * Displays the site's registration settings.
     */
    public function sectionRegistrationLogin()
    {
        if (!auth()->user()->can('admin.settings')) {
            if ($this->request->isHtmx()) {
                return $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.notAuthorized')]);
            } else {
                alertHtmx('danger', lang('Btw.message.notAuthorized'));
                return redirect()->to(ADMIN_AREA)->with('htmx:errorPermisssion', lang('Btw.message.notAuthorized'));
            }
        }

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_registration', [
                'rememberOptions' => $this->rememberOptions,
                'defaultGroup' => setting('AuthGroups.defaultGroup'),
                'groups' => setting('AuthGroups.groups'),
                'menu' => service('menus')->menu('sidebar_on'),
                'currentUrl' => request()->getUri()->getPath()
            ]);
        }
        switch ($this->request->getVar('section')) {
            case 'registration':
                $data = $this->request->getPost();
                $validation = service('validation');

                $validation->setRules([
                    'defaultGroup' => 'required|string',
                ]);

                if (!$validation->run($data)) {
                    $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.formValidationFailed', [lang('Btw.general.settings')])]);
                    return view('Btw\Core\Views\Admin\settings\cells\form_cell_registration', [
                        'groups' => setting('AuthGroups.groups'),
                        'defaultGroup' => setting('AuthGroups.defaultGroup'),
                        'validation' => $validation
                    ]);
                    ;
                }

                setting('Auth.allowRegistration', $data['allowRegistration'] ?? false);
                Setting('AuthGroups.defaultGroup', $data['defaultGroup']);

                // Actions
                $actions = setting('Auth.actions');
                $actions['register'] = $data['emailActivation'] ?? null;
                setting('Auth.actions', $actions);

                $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.settings')])]);
                $this->response->triggerClientEvent('updateSettingsRegistration');

                return view('Btw\Core\Views\Admin\settings\cells\form_cell_registration', [
                    'groups' => setting('AuthGroups.groups'),
                    'defaultGroup' => setting('AuthGroups.defaultGroup'),
                ]);

                break;

            case 'login':

                $data = $this->request->getPost();

                // Remember Me
                $sessionConfig = setting('Auth.sessionConfig');
                $sessionConfig['allowRemembering'] = $data['allowRemember'] ?? false;
                $sessionConfig['rememberLength'] = $data['rememberLength'];
                setting('Auth.sessionConfig', $sessionConfig);

                // Actions
                $actions = setting('Auth.actions');
                $actions['login'] = $data['email2FA'] ?? null;
                setting('Auth.actions', $actions);

                $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.settings')])]);
                return view('Btw\Core\Views\Admin\settings\cells\form_cell_login', [
                    'rememberOptions' => $this->rememberOptions,
                    'groups' => setting('AuthGroups.groups'),
                    'defaultGroup' => setting('AuthGroups.defaultGroup'),
                ]);

                break;
            default:
                alertHtmx('danger', lang('Btw.erreor', ['settings']));
        }
    }


    /**
     * Displays the site's passwords settings.
     */
    public function sectionPasswords()
    {

        if (!auth()->user()->can('admin.settings')) {
            if ($this->request->isHtmx()) {
                return $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.notAuthorized')]);
            } else {
                alertHtmx('danger', lang('Btw.message.notAuthorized'));
                return redirect()->to(ADMIN_AREA)->with('htmx:errorPermisssion', lang('Btw.message.notAuthorized'));
            }
        }

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_passwords', [
                'menu' => service('menus')->menu('sidebar_on'),
                'currentUrl' => request()->getUri()->getPath()
            ]);
        }

        $data = $this->request->getPost();
        $validation = service('validation');

        $validation->setRules([
            'minimumPasswordLength' => 'required|integer|greater_than[6]'
        ]);

        if (!$validation->run($data)) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.formValidationFailed', [lang('Btw.general.settings')])]);
            return view('Btw\Core\Views\Admin\users\form_cell_password', [
                'validation' => $validation
            ]);
            ;
        }

        setting('Auth.minimumPasswordLength', (int) $data['minimumPasswordLength']);
        setting('Auth.passwordValidators', $data['validators']);

        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.settings')])]);
        return view('Btw\Core\Views\Admin\settings\cells\form_cell_password', [
            'groups' => setting('AuthGroups.groups'),
            'defaultGroup' => setting('AuthGroups.defaultGroup'),
        ]);
    }


    /**
     * Displays the site's passwords settings.
     */
    public function sectionAvatar()
    {

        if (!auth()->user()->can('admin.settings')) {
            if ($this->request->isHtmx()) {
                return $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.notAuthorized')]);
            } else {
                alertHtmx('danger', lang('Btw.message.notAuthorized'));
                return redirect()->to(ADMIN_AREA)->with('htmx:errorPermisssion', lang('Btw.message.notAuthorized'));
            }
        }

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_avatar', [
                'menu' => service('menus')->menu('sidebar_on'),
                'currentUrl' => request()->getUri()->getPath()
            ]);
        }


        $data = $this->request->getPost();

        // Avatars
        setting('Users.useGravatar', $data['useGravatar'] ?? false);
        setting('Users.gravatarDefault', $data['gravatarDefault']);
        setting('Users.avatarNameBasis', $data['avatarNameBasis']);

        $this->response->triggerClientEvent('updateAvatar', time(), 'receive');
        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.settings')])]);

        return view('Btw\Core\Views\Admin\settings\cells\form_cell_avatar', [
            'groups' => setting('AuthGroups.groups'),
            'defaultGroup' => setting('AuthGroups.defaultGroup'),
        ]);
    }

    public function sectionEmail()
    {

        if (!auth()->user()->can('admin.settings')) {
            if ($this->request->isHtmx()) {
                return $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.notAuthorized')]);
            } else {
                alertHtmx('danger', lang('Btw.message.notAuthorized'));
                return redirect()->to(ADMIN_AREA)->with('htmx:errorPermisssion', lang('Btw.message.notAuthorized'));
            }
        }

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_email', [
                'config' => config('Email'),
                'activeTab' => setting('Email.protocol') ?? 'smtp',
                'menu' => service('menus')->menu('sidebar_on'),
                'currentUrl' => request()->getUri()->getPath()
            ]);
        }

        $data = $this->request->getPost();
        $validation = service('validation');

        $validation->setRules([
            'fromName' => 'required|string|min_length[2]',
            'fromEmail' => 'required|valid_email',
            'protocol' => 'required|in_list[mail,sendmail,smtp]',
            'mailPath' => 'permit_empty|string',
            'SMTPHost' => 'permit_empty|string',
            'SMTPPort' => 'permit_empty|in_list[25,587,465,2525,other]',
            'SMTPPortOther' => 'permit_empty|string',
            'SMTPUser' => 'permit_empty|string',
            'SMTPPass' => 'permit_empty|string',
            'SMTPCrypto' => 'permit_empty|in_list[ssl,tls]',
            'SMTPTimeout' => 'permit_empty|integer|greater_than_equal_to[0]',
            'SMTPKeepAlive' => 'permit_empty|in_list[0,1]',
        ]);

        if (!$validation->run($data)) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.formValidationFailed', [lang('Btw.general.settings')])]);
            $this->response->setReswap('outerHTML');
            return view('Btw\Core\Views\Admin\settings\cells\form_cell_email', [
                'config' => config('Email'),
                'activeTab' => setting('Email.protocol') ?? 'smtp',
                'validation' => $validation
            ]);
        }

        $port = $data['SMTPPort'] === 'other'
            ? $data['SMTPPortOther']
            : $data['SMTPPort'];

        setting('Email.fromName', $data['fromName']);
        setting('Email.fromEmail', $data['fromEmail']);
        setting('Email.protocol', $data['protocol']);
        setting('Email.mailPath', $data['mailPath']);
        setting('Email.SMTPHost', $data['SMTPHost']);
        setting('Email.SMTPPort', $port);
        setting('Email.SMTPUser', $data['SMTPUser']);
        setting('Email.SMTPPass', $data['SMTPPass']);
        setting('Email.SMTPCrypto', $data['SMTPCrypto']);
        setting('Email.SMTPTimeout', $data['SMTPTimeout']);
        setting('Email.SMTPKeepAlive', $data['SMTPKeepAlive']);

        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.settings')])]);
        return view('Btw\Core\Views\Admin\settings\cells\form_cell_email', [
            'config' => config('Email'),
            'activeTab' => setting('Email.protocol') ?? 'smtp'
        ]);
    }



    /**
     * Displays the site's passwords settings.
     */
    public function sectionOauth()
    {

        if (!auth()->user()->can('admin.settings')) {
            if ($this->request->isHtmx()) {
                return $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.notAuthorized')]);
            } else {
                alertHtmx('danger', lang('Btw.message.notAuthorized'));
                return redirect()->to(ADMIN_AREA)->with('htmx:errorPermisssion', lang('Btw.message.notAuthorized'));
            }
        }

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_oauth', [
                'menu' => service('menus')->menu('sidebar_on'),
                'currentUrl' => request()->getUri()->getPath()
            ]);
        }

        $data = $this->request->getPost();

        // Oauth
        setting('ShieldOAuthConfig.allow_login', $data['allow_login'] ?? false);
        setting('ShieldOAuthConfig.allow_register', $data['allow_register'] ?? false);
        setting('ShieldOAuthConfig.allow_login_google', $data['allow_login_google'] ?? false);
        setting('ShieldOAuthConfig.google_client_id', $data['google_client_id']);
        setting('ShieldOAuthConfig.google_client_secret', $data['google_client_secret']);

        $this->response->triggerClientEvent('updateOauth', time(), 'receive');
        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.settings')])]);

        return view('Btw\Core\Views\Admin\settings\cells\form_cell_oauth', [
            'defaultGroup' => setting('AuthGroups.defaultGroup'),
        ]);
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
        $item = new MenuItem([
            'title' => 'Général',
            'namedRoute' => 'settings-general',
            'fontIconSvg' => theme()->getSVG('duotune/abstract/abs029.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view',
            'weight' => 1
        ]);
        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' => lang('Btw.sidebar.LoginAndRegistration'),
            'namedRoute' => 'settings-registration',
            'fontIconSvg' => theme()->getSVG('duotune/general/gen048.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view',
            'weight' => 2
        ]);
        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' => lang('Btw.sidebar.passwords'),
            'namedRoute' => 'settings-passwords',
            'fontIconSvg' => theme()->getSVG('duotune/general/gen047.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view',
            'weight' => 3
        ]);
        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' => 'Avatar',
            'namedRoute' => 'settings-avatar',
            'fontIconSvg' => theme()->getSVG('duotune/general/gen065.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view',
            'weight' => 4
        ]);
        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' => 'Email',
            'namedRoute' => 'settings-email',
            'fontIconSvg' => theme()->getSVG('duotune/general/gen016.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view',
            'weight' => 5
        ]);
        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' => 'Oauth',
            'namedRoute' => 'settings-oauth',
            'fontIconSvg' => theme()->getSVG('duotune/general/gen062.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view',
            'weight' => 6
        ]);
        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' =>  lang('Btw.sidebar.update'),
            'namedRoute' => 'settings-update',
            'fontIconSvg' => theme()->getSVG('duotune/coding/cod005.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view',
            'weight' => 7
        ]);

        $sidebar->menu('sidebar_on')->collection('content')->addItem($item);
    }
}
