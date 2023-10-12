<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Controllers\Admin;

use Btw\Core\Controllers\AdminController;
use CodeIgniter\CodeIgniter;

class SystemInfoController extends AdminController
{
    protected $theme      = 'admin';
    protected $viewPrefix = 'Btw\Core\Views\Admin\\tools\\';

    /**
     * Displays basic information about the site.
     *
     * @return string
     */
    public function index()
    {
        global $app;
        $db = db_connect();

        helper('filesystem');
        helper('number');

        return $this->render($this->viewPrefix . 'index', [
            'ciVersion'  => CodeIgniter::CI_VERSION,
            'dbDriver'   => $db->DBDriver,
            'dbVersion'  => $db->getVersion(),
            'serverLoad' => function_exists('sys_getloadavg') ? current(sys_getloadavg()) : null,
        ]);
    }

    /**
     * Displays Detailed PHP Info
     */
    public function phpInfo()
    {
        echo phpinfo();
    }
}
