<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableSelect extends Cell
{
    protected string $view = 'datatable_select';
    public $row;

    public function mount(object $row)
    {
        $this->row = $row;
    }
}