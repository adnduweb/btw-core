<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableDFilter extends Cell
{
    protected string $view = 'datatable_d_filter';
    public $fieldsFilter;

    public function mount($fieldsFilter)
    {
        $this->fieldsFilter = $fieldsFilter;
    }
}
