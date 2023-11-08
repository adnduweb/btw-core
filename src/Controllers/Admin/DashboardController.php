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
use Btw\Core\Libraries\StatsManager;

/**
 * Class Dashboard
 *
 * The primary entry-point to the Bonfire admin area.
 */
class DashboardController extends AdminController
{

    protected $viewPrefix = 'Btw\Core\Views\Admin\\dashboard\\';

    /**
     * Displays the site's initial page.
     */
    public function index()
    {
        // Add the page title
        service('viewMeta')->setTitle('My Site');

        // print_r(service('Notices')->instanceAll()); exit;

        return $this->render($this->viewPrefix . 'index', [
            'cells' => new StatsManager(),
        ]);
    }
}
