<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableEmail extends Cell
{
    protected string $view = 'datatable_email';
    public $row;

    public function mount(object $row)
    {
        $this->row = $row;
    }
}