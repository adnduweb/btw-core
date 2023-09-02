<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableRowSelectedTable extends Cell
{
    protected string $view = 'datatable_row_selected_table';

    public $menu = [];
    public string $currentUrl;

    public function mount()
    {
        
    }
}