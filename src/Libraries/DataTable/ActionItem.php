<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Libraries\DataTable;

/**
 * Represents an individual item in a menu.
 *
 * @property string $edit
 * @property string $delete
 * @property string $active
 * @property string $desactive
 */
class ActionItem
{

    /**
     * @var array|null
     */
    protected static $actions;

    /**
     * @var string|null
     */
    protected $edit;

    /**
     * @var string|null
     */
    protected $delete;

    /**
     * @var string|null
     */
    protected $activate;

    /**
     * @var string|null
     */
    protected $desactivate;

    protected $actionsAllFalse = [];

    /**
     * @var array|null
     */
    protected $custom = [];

    /**
     * @var string|null
     */
    protected $module;


    public function __construct(?array $actions = null, ?object $objectRows = null)
    {
        self::$actions = $actions;
        if (!is_array($actions)) {
            return;
        }

        foreach ($actions as $key) {
            if (!is_array($key)) {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->{$method}($key, $objectRows);
                }
            }
        }

        if (isset($actions['custom'])) {
            $this->setCustom($actions['custom'], $objectRows);
        }
    }

    /**
     * @return $this
     */
    public function setEdit(string $edit, object $objectRows)
    {
        $this->edit = true;

        if (!auth()->user()->can(self::getController() . '.edit')) {
            $this->edit = false;
        }

        if (get_class($objectRows) == 'Btw\Core\Entities\User' && (auth()->user()->inGroup('admin') && $objectRows->inGroup('superadmin'))) {

            $this->actionsAllFalse['edit'] = $this->edit = false;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setDelete(string $delete, object $objectRows)
    {
        $this->delete = true;

        // var_dump(auth()->user()->can(self::getController() . '.delete'));
        // var_dump(auth()->user()->can('admin.delete'));


        // Permissions du module
        if (!auth()->user()->can(self::getController() . '.delete')) {
            $this->delete = false;
        }

        // Permissions global
        if (auth()->user()->can('admin.delete')) {
            $this->delete = true;
        }

        if (get_class($objectRows) == 'Btw\Core\Entities\User' && (auth()->user()->inGroup('admin') && $objectRows->inGroup('superadmin'))) {
            $this->actionsAllFalse['delete'] = $this->delete = false;
        }

        if (get_class($objectRows) == 'Btw\Core\Entities\User' && (auth()->user()->id == $objectRows->getIdentifier())) {
            $this->actionsAllFalse['delete'] = $this->delete = false;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setActivate(string $activate, object $objectRows)
    {
        $this->activate = true;

        if (!auth()->user()->can(self::getController() . '.edit')) {
            $this->activate = true;
        }

        if (get_class($objectRows) == 'Btw\Core\Entities\User' && (auth()->user()->inGroup('admin') && $objectRows->inGroup('superadmin'))) {
            $this->actionsAllFalse['activate'] =  $this->activate = false;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setDesactivate(string $desactivate, object $objectRows)
    {
        $this->desactivate = true;

        if (!auth()->user()->can(self::getController() . '.edit')) {
            $this->desactivate = true;
        }

        if (get_class($objectRows) == 'Btw\Core\Entities\User' && (auth()->user()->inGroup('admin') && $objectRows->inGroup('superadmin'))) {
            $this->actionsAllFalse['desactivate'] =  $this->desactivate = false;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setCustom(array $custom, object $objectRows)
    {

        if (!auth()->user()->can(self::getController() . '.edit')) {
            $this->custom = true;
        }

        if (!is_array($custom))
            return false;

            foreach($custom as $cus){

                $this->custom['list'][] = $cus;
                
            }

            $handle = explode('\\', get_class($objectRows));
            $this->custom['module'] = $this->module = end($handle);


        // print_r($this->custom);
        // print_r($objectRows);
        // exit;
        // $this->custom = true;

        if (get_class($objectRows) == 'Btw\Core\Entities\User' && (auth()->user()->inGroup('admin') && $objectRows->inGroup('superadmin'))) {
            $this->actionsAllFalse['custom'] =  $this->custom = false;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function edit()
    {
        return $this->edit;
    }

    /**
     * @return string
     */
    public function delete()
    {
        return $this->delete;
    }

    /**
     * @return string
     */
    public function active()
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function desactive()
    {
        return $this->desactive;
    }

     /**
     * @return array
     */
    public function custom()
    {
        return $this->custom;
    }

    public function __get(string $key)
    {
        if (method_exists($this, $key)) {
            return $this->{$key}();
        }
    }

    public static function getController()
    {

        $controllerName = service('router')->controllerName();
        $handle = explode('\\', $controllerName);
        $end = end($handle);
        $controller = strtolower(str_replace('Controller', '', $end));
        return $controller;
    }
    public function getAll()
    {
        // echo count(self::$actions); 
        // echo ' -- ';
        // print_r($this->actionsAllFalse); 
        // echo ' -- ';
        // echo count($this->actionsAllFalse); 
        if (count(self::$actions) == count($this->actionsAllFalse)) {
            return false;
        }
        // echo 'ffffffff';
        return true;
    }
}
