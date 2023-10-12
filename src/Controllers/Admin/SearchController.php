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
use Btw\Core\Libraries\SearchManager;

class SearchController extends AdminController
{
    protected $theme      = 'admin';
    protected $viewPrefix = 'Btw\Core\Views\Admin\\search\\';


    public function __construct()
    {
    }

    /**
     * Displays basic information about the site.
     *
     * @return string
     */
    public function search()
    {

        if (!auth()->user()->can('admin.settings')) {
            return redirect()->to(ADMIN_AREA)->with('error', lang('Btw.notAuthorized'));
        }
        $this->response->triggerClientEvent('openmodalslideover');

        return $this->render('Btw\Core\Cells\Core\admin_side_over', [
            'cells' => new SearchManager(),
        ]);



        // if (!$this->request->is('post')) {
        // return $this->render($this->viewPrefix . 'index', [
        //     'tokens'  => Auth()->user()->accessTokens(),
        //     'menu' => service('menus')->menu('sidebar_token'),
        //     'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
        // ]);
        // }
    }
}
