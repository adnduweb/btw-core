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
use InvalidArgumentException;
use Btw\Core\Libraries\TableHelper;

/**
 * Class Dashboard
 *
 * The primary entry-point to the Bonfire admin area.
 */
class PermissionsController extends AdminController
{

    /**
     * Base URL.
     */
    protected string $baseURL = 'admin/permissions-list';

    /**
     * Base Views.
     */
    protected $viewPrefix = 'Btw\Core\Views\Admin\permissions\\';

    /**
     * Displays the site's initial page.
     */
    public function index()
    {

        $data = [
            'limit'         => $this->request->getGet('limit') ?? 5,
            'page'          => $this->request->getGet('page') ?? 1,
            'search'        => $this->request->getGet('search') ?? '',
            'sortColumn'    => $this->request->getGet('sortColumn') ?? 'title',
            'sortDirection' => $this->request->getGet('sortDirection') ?? 'asc',
            'collapse'      => true
        ];

        $rules = [
            'limit'         => ['is_natural_no_zero', 'less_than_equal_to[10]'],
            // 'page'          => ['is_natural', 'greater_than_equal_to[1]'],
            'search'        => ['string'],
            'sortColumn'    => ['in_list[title,description,alias,user_count]'],
            'sortDirection' => ['in_list[asc,desc]'],
        ];

        if (!$this->validateData($data, $rules)) {
            throw new InvalidArgumentException(implode(PHP_EOL, $this->validator->getErrors()));
        }



        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }


        $data['permissions'] = $permissions;

        $data['table'] = new TableHelper($this->baseURL, $data['sortColumn'], $data['sortDirection']);
       
        //print_r($data); exit;

        if ($this->request->isHtmx() && !$this->request->isBoosted()) {
            return view('Btw\Core\Views\Admin\permissions\table', $data);
        }

        echo $this->render($this->viewPrefix . 'index', $data);
    }
}
