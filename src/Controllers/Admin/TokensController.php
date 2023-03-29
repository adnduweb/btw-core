<?php

/**
 * This file is part of Bonfire.
 *
 * (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Controllers\Admin;

use Btw\Core\Controllers\AdminController;
use CodeIgniter\CodeIgniter;
use Btw\Core\Libraries\Menus\MenuItem;

class TokensController extends AdminController
{
    protected $theme      = 'Admin';
    protected $viewPrefix = 'Btw\Core\Views\Admin\\tools\\tokens\\';


    public function __construct()
    {
        self::setupMenus();
        $this->addMenuSidebar();
    }

    /**
     * Displays basic information about the site.
     *
     * @return string
     */
    public function index()
    {

        if (!auth()->user()->can('admin.settings')) {
            return redirect()->to(ADMIN_AREA)->with('error', lang('Btw.notAuthorized'));
        }

        if (!$this->request->is('post')) {
            return $this->render($this->viewPrefix . 'token-manage', [
                'tokens'  => Auth()->user()->accessTokens(),
                'menu' => service('menus')->menu('sidebar_token'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }
    }

        /**
     * Displays basic information about the site.
     *
     * @return string
     */
    public function create()
    {

        if (!auth()->user()->can('admin.settings')) {
            return redirect()->to(ADMIN_AREA)->with('error', lang('Btw.notAuthorized'));
        }

        if (!$this->request->is('post')) {
            return $this->render($this->viewPrefix . 'token-create', [
                'menu' => service('menus')->menu('sidebar_token'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }
    }

    

    /**
     * Creates any admin-required menus so they're
     * available to use by any modules.
     */
    private function setupMenus()
    {
        $menus = service('menus');

        // Sidebar menu
        $menus->createMenu('sidebar_token');
        $menus->menu('sidebar_token')
            ->createCollection('content', 'Content');
    }

    public function addMenuSidebar()
    {
        $sidebar = service('menus');
        $item    = new MenuItem([
            'title'           => 'Manage',
            'namedRoute'      => 'tokens-manage',
            'fontIconSvg'     => theme()->getSVG('duotune/abstract/abs029.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 1
        ]);
        $sidebar->menu('sidebar_token')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Create API Token',
            'namedRoute'      => 'tokens-create',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen048.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 2
        ]);
        $sidebar->menu('sidebar_token')->collection('content')->addItem($item);
    }
}
