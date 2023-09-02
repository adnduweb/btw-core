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

    public function mount(array $add, array $actions, $filter = false, array $fieldsFilter = [], array $settings = []) 
    {
        $this->filter =  $filter;
        $this->fieldsFilter = $fieldsFilter;
        $this->actions = $actions;
        $this->add = $add;
        $this->settings = $settings;      
    }
}