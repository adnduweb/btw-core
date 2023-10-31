<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableAskAuth extends Cell
{
    protected string $view = 'datatable_ask_auth';
    public $row;
    protected string $hxTrigger = 'updateListrow';
    protected string $module;

    public function mount(object $row)
    {
        $this->row = $row;
    }

    protected function getModuleProperty(): string
    {
        $controllerName = service('router')->controllerName();
        $handle = explode('\\', $controllerName);
        $end = end($handle);
        $_controller = strtolower(str_replace('Controller', '', $end));
        $_method = service('router')->methodName();
        $this->module = strtolower($_controller) . '-' . strtolower($_method);
        return $this->module;
    }

    protected function getHxTriggerProperty(): string
    {

        return $this->hxTrigger;
    }
}
