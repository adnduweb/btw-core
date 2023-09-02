<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableUsername extends Cell
{
    protected string $view = 'datatable_username';
    public $row;

    public function mount(object $row)
    {
        $this->row = $row;
    }
}