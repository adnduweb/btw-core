<?php

namespace Btw\Core\Cells\Forms;

use CodeIgniter\View\Cells\Cell;

class AdminButtonSave extends Cell
{
    protected string $view = 'admin_button_save';
    public string $text;
    public string $type;
    public string $loading;
    public $back = null;
    public $click;
    public $class;

    public function mount(string $type, string $text, string $loading, $back = null, $click = null, $class = "")
    {
        $this->type = $type;
        $this->text = $text;
        $this->loading = $loading;
        $this->back = $back;
        $this->click = $click;
        $this->class = $class;
    }
}
