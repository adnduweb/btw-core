<?php

namespace Btw\Core\Cells\Datatable;

use CodeIgniter\View\Cells\Cell;

class DatatableDropdown extends Cell
{
    protected string $view = 'datatable_dropdown';
    public $row;
    public $identifier;
    public $select;
    public $name;
    public $byKey;
    public $selected;
    public $hxGet;

    public function mount(
        $row,
        $identifier,
        $select,
        $name,
        $byKey,
        $selected,
        $hxGet
    ) {
        $this->row = $row;
        $this->identifier = $identifier;
        $this->select = $select;
        $this->name = $name;
        $this->byKey = $byKey;
        $this->selected = $selected;
        $this->hxGet = $hxGet;
    }
}
