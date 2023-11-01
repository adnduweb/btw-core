<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableAskAuth extends Cell
{
    protected string $view = 'datatable_ask_auth';
    public $row;
    protected string $hxTrigger = 'updateListrow';
    protected string $module;
    protected string $controller = "home";
    protected string $method = "index";

    public function mount(object $row)
    {
        $this->row = $row;
    }

    protected function getModuleProperty(): string
    {
        $this->module = strtolower($this->controller) . '-' . strtolower($this->method);
        return $this->module;
    }

    protected function getHxTriggerProperty(): string
    {
        return $this->hxTrigger;
    }

    protected function getMethodProperty(): string
    {
        return $this->method;
    }
    protected function getControllerProperty(): string
    {
        return $this->controller;
    }
}
