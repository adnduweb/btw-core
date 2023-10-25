<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableAskAuth extends Cell
{
    protected string $view = 'datatable_ask_auth';
    public $row;

    public function mount(object $row)
    {
        $this->row = $row;
    }
}
