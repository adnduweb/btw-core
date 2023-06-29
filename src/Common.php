<?php

use CodeIgniter\Config\Services;
use Btw\Core\View\Theme;
use CodeIgniter\I18n\Time;
use CodeIgniter\Config\View;


if (!function_exists('newUUID')) {
    function newUUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}

if (!function_exists('vite')) {
    function vite(array $paths)
    {

        $manifest = FCPATH . 'manifest.json';

        $result = [
            'js' => null,
            'css' => null
        ];

        $html = '';

        # Check if vite is running.
        $entryFile = env('VITE_ORIGIN') . '/' . env('VITE_RESOURCES_DIR') . '/' . env('VITE_ENTRY_FILE');

        $result['js'] = @file_get_contents($entryFile) ? '<script type="module" src="' . $entryFile . '"></script>' : null;
        $html .= $result['js'];

        # If vite isn't running, then return the bundled resources.
        if (empty($result['js']) && is_file($manifest)) {
            # Get the manifest content.
            $manifest = file_get_contents($manifest);
            # You look much pretty as a php object =).
            $manifest = json_decode($manifest);

            # Now, we will get all js files and css from the manifest.
            foreach ($manifest as $file) {
                // print_r($file);exit; 
                # Check extension
                $fileExtension = substr($file->file, -3, 3);

                # Generate js tag.
                if ($fileExtension === '.js' && isset($file->isEntry) && $file->isEntry === true && (!isset($file->isDynamicEntry) || $file->isDynamicEntry !== true)) {
                    $result['js'] .= '<script type="module" src="/' . $file->file . '"></script>' . "\n";
                    $html .= $result['js'];
                }

                if (!empty($file->css)) {
                    foreach ($file->css as $cssFile) {
                        $result['css'] .= '<link rel="stylesheet" href="/' . $cssFile . '" />' . "\n";
                        $html .= $result['css'];
                    }
                }
            }
        }

        return $html;
    }
}

if (!function_exists('view_fragment')) {
    /**
     * Grabs the current RendererInterface-compatible class
     * and tells it to render the specified view fragments.
     * Simply provides a convenience method that can be used
     * in Controllers, libraries, and routed closures.
     *
     * NOTE: Does not provide any escaping of the data, so that must
     * all be handled manually by the developer.
     *
     * @param array $options Options for saveData or third-party extensions.
     */
    function view_fragment(string $name, string|array $fragments, array $data = [], array $options = []): string
    {
        $renderer = Services::renderer();

        /** @var View $config */
        $config = config(View::class);
        $saveData = $config->saveData;

        if (array_key_exists('saveData', $options)) {
            $saveData = (bool) $options['saveData'];
            unset($options['saveData']);
        }

        $options['fragments'] = is_string($fragments)
            ? array_map('trim', explode(',', $fragments))
            : $fragments;

        return $renderer->setData($data, 'raw')->render($name, $options, $saveData);
    }
}


if (!function_exists('has_error')) {
    /**
     * Determines whether an error exists
     * for a form field. This requires the errors
     * are passed back like:
     *  return redirect()->back()->with('errors', $this->validation->getErrors());
     */
    function has_error(string $field): bool
    {
        if (!session()->has('errors')) {
            return false;
        }

        return isset(session('errors')[$field]);
    }
}

if (!function_exists('error')) {
    /**
     * Displays the error message for a single form field.
     */
    function error(string $field)
    {
        return session('errors')[$field] ?? '';
    }
}

if (!function_exists('app_date')) {
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

if (!function_exists('app_datesql')) {

    function app_datesql($date): string
    {
        list($d, $m, $y) = explode('/', $date);
        return $y . '/' . $m . '/' . $d;
    }
}


if (!function_exists('render')) {
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

        $viewMeta = service('viewMeta');
        $data['viewMeta'] = $viewMeta;

        $viewJavascript = service('viewJavascript');
        $data['viewJavascript'] = $viewJavascript;

        return $renderer->setData($data)
            ->render($view, $options, true);
    }
}


if (!function_exists('viewBtw')) {
    /**
     *  A view using the current theme.
     *
     * @return string
     */
    function viewBtw(string $theme, string $view, array $data = [], array $options = []): string
    {

        Theme::setTheme($theme);
        $path = Theme::path();

        $renderer = single_service('renderer', $path);

        $viewMeta = service('viewMeta');
        $data['viewMeta'] = $viewMeta;

        $viewJavascript = service('viewJavascript');
        $data['viewJavascript'] = $viewJavascript;

        $config = config(View::class);
        $saveData = $config->saveData;

        if (array_key_exists('saveData', $options)) {
            $saveData = (bool) $options['saveData'];
            unset($options['saveData']);
        }

        return $renderer->setData($data, 'raw')->render($view, $options, $saveData);
    }
}

if (!function_exists('site_offline')) {
    /**
     * Determines whether the site is offline.
     */
    function site_offline(): bool
    {
        return empty(setting('Site.siteOnline'));
    }
}

if (!defined('theme')) {
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
        $agent = service('request')->getUserAgent();

        $support = '';
        if ($agent->isBrowser()) {
            // $currentAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
            $currentAgent = $agent->getBrowser();
            $support = 'sp_desktop';
        } elseif ($agent->isRobot()) {
            $currentAgent = $this->agent->robot();
            $support = 'sp_robot';
        } elseif ($agent->isMobile()) {
            $currentAgent = $agent->getMobile();
            $support = 'sp_mobile';
        } else {
            $currentAgent = 'Unidentified User Agent';
            $support = 'sp_unknow';
        }

        if ($html === true) {
            return strtolower(str_replace(['-', '', ' ', '.'], ['_'], $currentAgent))
                . ' version_' . strtolower(str_replace(['-', '', ' ', '.'], ['_'], $agent->getVersion()))
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
                'lang' => $ipdat->geoplugin_longitude,
                'flag' => true
            );
        } else {
            return array(
                'country' => '',
                'code' => '',
                'city' => '',
                'lat' => '',
                'lang' => '',
                'flag' => false
            );
        }
    }
}

if (!function_exists('generateUsername')) {
    function generateUsername($fullName)
    {
        $removedMultispace = preg_replace('/\s+/', ' ', $fullName);

        $sanitized = preg_replace('/[^A-Za-z0-9\ ]/', '', $removedMultispace);

        $lowercased = strtolower($sanitized);

        $splitted = explode(" ", $lowercased);

        if (count($splitted) == 1) {
            $username = substr($splitted[0], 0, rand(3, 6)) . rand(111111, 999999);
        } else {
            $username = $splitted[0] . substr($splitted[1], 0, rand(0, 4)) . rand(11111, 99999);
        }

        return $username;
    }
}

if (!function_exists('getAdminToken')) {
    /**
     * Tokenize a string.
     *
     * @param string $string string to encript
     */
    function getAdminToken($string)
    {
        return !empty($string) ? hashToken($string) : false;
    }
}

if (!function_exists('hashToken')) {
    /**
     * Hash password.
     *
     * @param string $passwd String to has
     *
     * @return string Hashed password
     *
     * @since 1.7.0
     */
    function hashToken($passwd)
    {
        return md5(env('encryption.key') . $passwd);
    }
}


if (!function_exists('removeAccents')) {
    /**
     * Traitement de texte.
     *
     * @param string $txt
     *
     * @return string
     */
    function removeAccents($txt)
    {
        $txt = str_replace('œ', 'oe', $txt);
        $txt = str_replace('Œ', 'Oe', $txt);
        $txt = str_replace('æ', 'ae', $txt);
        $txt = str_replace('Æ', 'Ae', $txt);
        $txt = str_replace('?', '', $txt);
        $txt = str_replace('.', '', $txt);
        mb_regex_encoding('UTF-8');
        $txt = mb_ereg_replace('[ÀÁÂÃÄÅĀĂǍẠẢẤẦẨẪẬẮẰẲẴẶǺĄ]', 'A', $txt);
        $txt = mb_ereg_replace('[àáâãäåāăǎạảấầẩẫậắằẳẵặǻą]', 'a', $txt);
        $txt = mb_ereg_replace('[ÇĆĈĊČ]', 'C', $txt);
        $txt = mb_ereg_replace('[çćĉċč]', 'c', $txt);
        $txt = mb_ereg_replace('[ÐĎĐ]', 'D', $txt);
        $txt = mb_ereg_replace('[ďđ]', 'd', $txt);
        $txt = mb_ereg_replace('[ÈÉÊËĒĔĖĘĚẸẺẼẾỀỂỄỆ]', 'E', $txt);
        $txt = mb_ereg_replace('[èéêëēĕėęěẹẻẽếềểễệ]', 'e', $txt);
        $txt = mb_ereg_replace('[ĜĞĠĢ]', 'G', $txt);
        $txt = mb_ereg_replace('[ĝğġģ]', 'g', $txt);
        $txt = mb_ereg_replace('[ĤĦ]', 'H', $txt);
        $txt = mb_ereg_replace('[ĥħ]', 'h', $txt);
        $txt = mb_ereg_replace('[ÌÍÎÏĨĪĬĮİǏỈỊ]', 'I', $txt);
        $txt = mb_ereg_replace('[ìíîïĩīĭįıǐỉị]', 'i', $txt);
        $txt = str_replace('Ĵ', 'J', $txt);
        $txt = str_replace('ĵ', 'j', $txt);
        $txt = str_replace('Ķ', 'K', $txt);
        $txt = str_replace('ķ', 'k', $txt);
        $txt = mb_ereg_replace('[ĹĻĽĿŁ]', 'L', $txt);
        $txt = mb_ereg_replace('[ĺļľŀł]', 'l', $txt);
        $txt = mb_ereg_replace('[ÑŃŅŇ]', 'N', $txt);
        $txt = mb_ereg_replace('[ñńņňŉ]', 'n', $txt);
        $txt = mb_ereg_replace('[ÒÓÔÕÖØŌŎŐƠǑǾỌỎỐỒỔỖỘỚỜỞỠỢ]', 'O', $txt);
        $txt = mb_ereg_replace('[òóôõöøōŏőơǒǿọỏốồổỗộớờởỡợð]', 'o', $txt);
        $txt = mb_ereg_replace('[ŔŖŘ]', 'R', $txt);
        $txt = mb_ereg_replace('[ŕŗř]', 'r', $txt);
        $txt = mb_ereg_replace('[ŚŜŞŠ]', 'S', $txt);
        $txt = mb_ereg_replace('[śŝşš]', 's', $txt);
        $txt = mb_ereg_replace('[ŢŤŦ]', 'T', $txt);
        $txt = mb_ereg_replace('[ţťŧ]', 't', $txt);
        $txt = mb_ereg_replace('[ÙÚÛÜŨŪŬŮŰŲƯǓǕǗǙǛỤỦỨỪỬỮỰ]', 'U', $txt);
        $txt = mb_ereg_replace('[ùúûüũūŭůűųưǔǖǘǚǜụủứừửữự]', 'u', $txt);
        $txt = mb_ereg_replace('[ŴẀẂẄ]', 'W', $txt);
        $txt = mb_ereg_replace('[ŵẁẃẅ]', 'w', $txt);
        $txt = mb_ereg_replace('[ÝŶŸỲỸỶỴ]', 'Y', $txt);
        $txt = mb_ereg_replace('[ýÿŷỹỵỷỳ]', 'y', $txt);
        $txt = mb_ereg_replace('[ŹŻŽ]', 'Z', $txt);
        $txt = mb_ereg_replace('[źżž]', 'z', $txt);
        return $txt;
    }
}

if (!function_exists('uniforme')) {
    /**
     * Traitement de texte.
     *
     * @param string $texte
     * @param string $sep
     *
     * @return string
     */
    function uniforme($texte, $sep = '-')
    {
        $texte = html_entity_decode($texte);
        $texte = removeAccents($texte);
        $texte = trim($texte);
        $texte = preg_replace('#[^a-zA-Z0-9.-]#', $sep, $texte);
        $texte = preg_replace('#-#', $sep, $texte);
        $texte = preg_replace('#_+#', $sep, $texte);
        $texte = preg_replace('#_$#', '', $texte);
        $texte = preg_replace('#^_#', '', $texte);
        $texte = preg_replace('/\s/', '', $texte);
        $texte = preg_replace('/\s\s+/', '', $texte);
        return strtolower($texte);
    }
}

if (!function_exists('getUser')) {
    function getUser(int $id): mixed
    {
        $user = model(UserModel::class)->find($id);

        return $user ?? 'system';
    }
}


if (!function_exists('secure_random_string')) {
    function secure_random_string($length)
    {
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $number = random_int(0, 36);
            $character = base_convert($number, 10, 36);
            $random_string .= $character;
        }
        return $random_string;
    }
}


// Mask email address with (*) stars
// Example: onl**************@g****.com

if (!function_exists('hideEmailAddressFull')) {

    function hideEmailAddressFull($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            list($first, $last) = explode('@', $email);
            $first = str_replace(substr($first, '3'), str_repeat('*', strlen($first) - 3), $first);
            $last = explode('.', $last);
            $last_domain = str_replace(substr($last['0'], '1'), str_repeat('*', strlen($last['0']) - 1), $last['0']);
            $hideEmailAddress = $first . '@' . $last_domain . '.' . $last['1'];
            return $hideEmailAddress;
        }
    }
}


// Mask email address with (*) stars
// Example: onlinewe********@gmail.com

if (!function_exists('hideEmailAddress')) {

    function hideEmailAddress($email)
    {
        $em = explode("@", $email);
        $name = implode(array_slice($em, 0, count($em) - 1), '@');
        $len = floor(strlen($name) / 2);
        return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
    }
}

// Convertit une date ou un timestamp en français
if (!function_exists('dateToFrench')) {
    function dateToFrench($date, $format)
    {
        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date))));
    }
}

if (!function_exists('json_readable_encode')) {
    function json_readable_encode($in, $indent = 0, $from_array = false)
    {
        $_myself = __FUNCTION__;
        $_escape = function ($str) {
            return preg_replace("!([\b\t\n\r\f\"\\'])!", "\\\\\\1", $str);
        };

        $out = '';

        foreach ($in as $inline) {
            foreach ($inline as $key => $value) {
                $out .= str_repeat("\t", $indent + 1);
                $out .= "\"" . $_escape((string) $key) . "\": ";

                if (is_object($value) || is_array($value)) {
                    $out .= "\n";
                    $out .= $_myself($value, $indent + 1);
                } elseif (is_bool($value)) {
                    $out .= $value ? 'true' : 'false';
                } elseif (is_null($value)) {
                    $out .= 'null';
                } elseif (is_string($value)) {
                    $out .= "\"" . $_escape($value) . "\"";
                } else {
                    $out .= $value;
                }

                $out .= ",\n";
            }
        }

        if (!empty($out)) {
            $out = substr($out, 0, -2);
        }

        $out = str_repeat("\t", $indent) . "{\n" . $out;
        $out .= "\n" . str_repeat("\t", $indent) . "}";

        return $out;
    }
}
if (!function_exists('build_list')) {

    function build_list($array)
    {
        $list = '<ol>';
        foreach ($array as $key => $value) {
            foreach ($value as $key => $index) {
                if (is_array($index)) {
                    $list .= build_list($index);
                } else {
                    $list .= "<li>$index</li>";
                }
            }
        }

        $list .= '</ol>';
        return $list;
    }
}

if (!function_exists('buildPermissionsTable')) {

    /**
     * Assumes Codeigniter - Shield - Creates a table row(s) to populate the Permissions Table.
     * This builds from the Shield auth_permissions_users DB Table
     * @param $user->getPermissions() should be stored like: "group.value" or "controller.permission" 
     *
     * This function will split from the "." and populate the table with:
     *      Group - Permission - Permission - Permission - Permission
     *      Controller - Permission - Permission - Permission - Permission
     *      ** Currently set to Create - Read - Update - Delete
     * 
     * @param $array = $user->getPermissions();
     * @param $permissionTable = buildPermissionsTable($array);
     * @param echo $permissionTable = build out HTML Table.
     * 
     * @return array|msg Returns a HTML Table array or `No Data` if `$array` is invalid or empty.
     * 
     * 
     */

    function buildPermissionsTable(array $array)
    {
        $pTableHeader = PHP_EOL . '<table class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">' . PHP_EOL . '<thead>' . PHP_EOL . '<tr>' . PHP_EOL . '<th><strong>' . lang('App.controller') . '</strong>:</th>' . PHP_EOL . '<th>Create</th>' . PHP_EOL . '<th>Read</th>' . PHP_EOL . '<th>Update</th>' . PHP_EOL . '<th>Delete</th>' . PHP_EOL . '</thead>' . PHP_EOL . '<tbody>' . PHP_EOL;
        $pTableFooter = PHP_EOL . '</tbody>' . PHP_EOL . '</table>';

        if (!$array) {
            $pTableBody = PHP_EOL . '<tr>' . PHP_EOL . '<td colspan="5" class="text-center">No Data Provided...</td>' . PHP_EOL . '</tr>' . PHP_EOL;
            return $pTableHeader . $pTableBody . $pTableFooter;
        }

        // This foreach loop will split the data based on the period into the first array
        // Example: array([controller] => activitylogs [permission] => read )
        $permData = [];
        foreach ($array as $key) {
            list($a, $b) = explode('.', $key);
            array_push($permData, [
                'controller' => $a,
                'permission' => $b,
            ]);
        }

        // Sorting the keys and values alphabetically
        asort($permData);


        // grouping to make the controller the index
        // Example: Array ( [activitylogs] => Array ( [0] => Array ( [controller] => activitylogs [permission] => read ) )

        $grouped = array_reduce(
            $permData,
            function ($carry, $item) {
                $carry[$item['controller']][] = $item;
                return $carry;
            },
            []
        );

        // Sorting again alphabetically - might not be needed but its free
        ksort($grouped);

        // Now that we have the array, lets build the HTML table
        foreach ($grouped as $key => $value):


            $pTableBody .= PHP_EOL . '<tr>' . PHP_EOL;
            $pTableBody .= '<td><strong>' . strtoupper($key) . '</strong></td>' . PHP_EOL;

            $pTableBody .= '<td class="text-center ' . ($value[0]['permission'] == '' ? 'text-danger' : 'text-success') . '"><i class="fas ' . ($value[0]['permission'] == '' ? 'fa-remove' : 'fa-check') . ' fa-xl"></i><br>' . $key . '.' . ($value[0]['permission'] == '' ? 'none!' : $value[0]['permission']) . '</td>' . PHP_EOL;
            $pTableBody .= '<td class="text-center ' . ($value[1]['permission'] == '' ? 'text-danger' : 'text-success') . '"><i class="fas ' . ($value[1]['permission'] == '' ? 'fa-remove' : 'fa-check') . ' fa-xl"></i><br>' . $key . '.' . ($value[1]['permission'] == '' ? 'none!' : $value[1]['permission']) . '</td>' . PHP_EOL;
            $pTableBody .= '<td class="text-center ' . ($value[2]['permission'] == '' ? 'text-danger' : 'text-success') . '"><i class="fas ' . ($value[2]['permission'] == '' ? 'fa-remove' : 'fa-check') . ' fa-xl"></i><br>' . $key . '.' . ($value[2]['permission'] == '' ? 'none!' : $value[2]['permission']) . '</td>' . PHP_EOL;
            $pTableBody .= '<td class="text-center ' . ($value[3]['permission'] == '' ? 'text-danger' : 'text-success') . '"><i class="fas ' . ($value[3]['permission'] == '' ? 'fa-remove' : 'fa-check') . ' fa-xl"></i><br>' . $key . '.' . ($value[3]['permission'] == '' ? 'none!' : $value[3]['permission']) . '</td>' . PHP_EOL;
            $pTableBody .= '</tr>' . PHP_EOL;
        endforeach;

        return $pTableHeader . $pTableBody . $pTableFooter;
    }
}

if (!function_exists('passwdGen')) {
    /**
     * Génaration d'un mot hexadecimal aléatoire.
     *
     * @param integer $length
     * @param string  $flag
     *
     * @return string
     */
    function passwdGen($length = 8, $flag = 'ALPHANUMERIC')
    {
        switch ($flag) {
            case 'NUMERIC':
                $str = '0123456789';
                break;
            case 'NO_NUMERIC':
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            default:
                $str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
        }
        for ($i = 0, $passwd = ''; $i < $length; $i++) {
            $passwd .= substr($str, mt_rand(0, strlen($str) - 1), 1);
        }
        return $passwd;
    }


    if (!function_exists('retirelignesvident')) {
        function retirelignesvident($string)
        {
            return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);
        }
    }
}