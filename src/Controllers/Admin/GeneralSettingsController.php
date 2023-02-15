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

    protected $viewPrefix = 'Btw\Core\Views\admin\settings\\';

    /**
     * Displays the site's general settings.
     */
    public function general()
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

        echo $this->render($this->viewPrefix . 'general', [
            'timezones'       => $timezoneAreas,
            'currentTZArea'   => $currentTZArea,
            'timezoneOptions' => $this->getTimezones($currentTZArea),
            'dateFormat'      => setting('App.dateFormat') ?: 'M j, Y',
            'timeFormat'      => setting('App.timeFormat') ?: 'g:i A',
        ]);
    }

    /**
     * Saves the general settings
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function saveGeneral()
    {
        if (!auth()->user()->can('admin.settings')) {
            return redirect()->to(ADMIN_AREA)->with('error', lang('Btw\Core.notAuthorized'));
        }

        $rules = [
            'siteName'   => 'required|string',
            'timezone'   => 'required|string',
            'dateFormat' => 'required|string',
            'timeFormat' => 'required|string',
        ];

        if (!$this->validate($rules)) {
            // return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            $response = [
                'messages' => [
                    'errors' => $this->validator->getErrors()
                ]
            ];
            return $this->respond($response, 422);
        }

        setting('Site.siteName', $this->request->getVar('siteName'));
        setting('Site.siteOnline', $this->request->getVar('siteOnline'));
        setting('App.appTimezone', $this->request->getVar('timezone'));

        setting('App.dateFormat', $this->request->getVar('dateFormat'));
        setting('App.timeFormat', $this->request->getVar('timeFormat'));

        $response = [
            'messages' => [
                'success' => lang('Btw.resourcesSaved', ['settings'])
            ]
        ];
        return $this->respond($response, 200);

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
}
