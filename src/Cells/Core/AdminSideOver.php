<?php

namespace Btw\Core\Cells\Core;

use CodeIgniter\View\Cells\Cell;
use Btw\Core\Libraries\SearchManager;

class AdminSideOver extends Cell
{
    protected string $view = 'admin_side_over';
    protected $cells;

    public function mount()
    {
        $this->cells = new SearchManager();
    }

    public function getCellsProperty()
    {
        return $this->cells;
    }
}
