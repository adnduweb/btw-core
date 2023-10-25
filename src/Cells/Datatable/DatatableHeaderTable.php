<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableHeaderTable extends Cell
{
    protected string $view = 'datatable_header_table';

    public $filter = false;
    public array $fieldsFilter = [];
    public array $actions = [];
    public array $add = [];
    public array $settings = [];
    public array $import = [];
    public array $export = [];
    public $_controller;
    public $_method;

    public function mount(array $add, array $actions, $filter = false, array $fieldsFilter = [], array $settings = [], array $import = [], array $export = [])
    {

        if(isset($add['htmx'])){
            $add['htmxFormat'] = '';
            foreach($add['htmx'] as $key => $value){
                $add['htmxFormat'] .= $key .'="'.$value.'" ';
            }
        }

        $this->filter =  $filter;
        $this->fieldsFilter = $fieldsFilter;
        $this->actions = $actions;
        $this->add = $add;
        $this->settings = $settings;
        $this->import = $import;
        $this->export = $export;

        $controllerName = service('router')->controllerName();
        $handle = explode('\\', $controllerName);$end = end($handle);
        $this->_controller = strtolower(str_replace('Controller', '', $end));
        $this->_method = service('router')->methodName();

    }
}
