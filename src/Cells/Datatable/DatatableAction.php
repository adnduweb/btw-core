<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableAction extends Cell
{
    protected string $view = 'datatable_action';
    public $row;
    public $actions;

    public function mount(object $row, $actions)
    {
        $this->row = $row;
        $this->actions = $actions;
    }
}