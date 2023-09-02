<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableSwitch extends Cell
{
    protected string $view = 'datatable_switch';
    public $row;
    public string $type;
    public string $hxGet;
    public string $hxSwap;

    public function mount(object $row, string $type, string $hxGet, string $hxSwap)
    {
        $this->row = $row;
        $this->type = $type;
        $this->hxGet = $hxGet;
        $this->hxSwap = $hxSwap;
    }
}