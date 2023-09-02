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
use Btw\Core\Entities\Company;
use Btw\Core\Models\CompanyModel;
use ReflectionException;


class CompanyController extends AdminController
{
    protected $theme = 'Admin';
    protected $viewPrefix = 'Btw\Core\Views\Admin\users\\profile\\';

    public function __construct()
    {
    }


    /**
     * Display the Email settings user.
     *
     * @return string
     */
    public function saveProfile()
    {
    }
}
