<?php

use Btw\Core\View\Theme;
use CodeIgniter\I18n\Time;

if (! function_exists('has_error')) {
    /**
     * Determines whether an error exists
     * for a form field. This requires the errors
     * are passed back like:
     *  return redirect()->back()->with('errors', $this->validation->getErrors());
     */
    function has_error(string $field): bool
    {
        if (! session()->has('errors')) {
            return false;
        }

        return isset(session('errors')[$field]);
    }
}

if (! function_exists('error')) {
    /**
     * Displays the error message for a single form field.
     */
    function error(string $field)
    {
        return session('errors')[$field] ?? '';
    }
}

if (! function_exists('app_date')) {
    /**
     * Formats a date according to the format
     * specified in the general settings page.
     *
     * It can take a string, a DateTime, or a Time instance.
     *
     * If $includeTimezone === true, will return the tz abbreviation
     * at the end of the date (i.e. CST, PST, etc)
     *
     * @param mixed $date
     *
     * @throws Exception
     */
    function app_date($date, bool $includeTime = false, bool $includeTimezone = false): string
    {
        $format = $includeTime
            ? [
                setting('App.dateFormat'),
                setting('App.timeFormat'),
                $includeTimezone ? 'T' : '',
            ]
            : [
                setting('App.dateFormat'),
                $includeTimezone ? 'T' : '',
            ];

        $format = trim(implode(' ', $format));

        if (is_string($date)) {
            $date = Time::parse($date);
        }

        $date->setTimezone(setting('App.appTimezone'));

        return $date->format($format);
    }
}

if (! function_exists('render')) {
    /**
     * Renders a view using the current theme.
     *
     * @return string
     */
    function render(string $theme, string $view, array $data = [], array $options = [])
    {
        helper('assets');

        Theme::setTheme($theme);
        $path = Theme::path();

        $renderer = single_service('renderer', $path);

        $viewMeta         = service('viewMeta');
        $data['viewMeta'] = $viewMeta;

        return $renderer->setData($data)
            ->render($view, $options, true);
    }
}

if (! function_exists('site_offline')) {
    /**
     * Determines whether the site is offline.
     */
    function site_offline(): bool
    {
        return empty(setting('Site.siteOnline'));
    }
}

if (! defined('theme')) {
    /**
     * Provides convenient access to the main Theme class
     * for CodeIgniter Theme.
     */
    function theme()
    {
        return service('theme');
    }
}


if (!function_exists('detectBrowser')) {
    /**
     * Detection du navigateur.
     *
     * @return string
     */
    function detectBrowser($html = true)
    {
        $agent   = service('request')->getUserAgent();

        $support = '';
        if ($agent->isBrowser()) {
            // $currentAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
            $currentAgent = $agent->getBrowser();
            $support      = 'sp_desktop';
        } elseif ($agent->isRobot()) {
            $currentAgent = $this->agent->robot();
            $support      = 'sp_robot';
        } elseif ($agent->isMobile()) {
            $currentAgent = $agent->getMobile();
            $support      = 'sp_mobile';
        } else {
            $currentAgent = 'Unidentified User Agent';
            $support      = 'sp_unknow';
        }

        if ($html === true) {
            return strtolower(str_replace(['-', '', ' ', '.'], ['_'], $currentAgent))
                . ' version_' .  strtolower(str_replace(['-', '', ' ', '.'], ['_'], $agent->getVersion()))
                . ' ' . strtolower(str_replace(['-', '', ' ', '.'], ['_'], $agent->getPlatform())) . ' ' . $support;
        } else {
            return $agent;
        }
    }
}

if (!function_exists('getCountryByIp')) {

    function getCountryByIp($ip)
    {
        try {
            $xml = file_get_contents(
                "http://www.geoplugin.net/json.gp?ip=" . $ip
            );
        } catch (Exception $exception) {
            $xml = null;
        }

        if (isset($xml)) {
            $ipdat = @json_decode($xml);
        } else {
            $xml = null;
        }


        if ($xml != null and isset($ipdat->geoplugin_countryName)) {
            return array(
                'country' => $ipdat->geoplugin_countryName,
                'code' => $ipdat->geoplugin_currencyCode,
                'city' => $ipdat->geoplugin_city,
                'lat' => $ipdat->geoplugin_latitude,
                'lang' => $ipdat->geoplugin_longitude, 'flag' => true
            );
        } else {
            return array(
                'country' => '',
                'code' => '',
                'city' => '',
                'lat' => '',
                'lang' => '', 'flag' => false
            );
        }
    }
}

