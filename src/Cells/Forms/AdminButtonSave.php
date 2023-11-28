<?php

namespace Btw\Core\Cells\Forms;

use CodeIgniter\View\Cells\Cell;

class AdminButtonSave extends Cell
{
    protected string $view = 'admin_button_save';
    protected $text;
    protected $name;
    protected $type;
    protected $loading;
    protected $back = null;
    protected $click;
    protected $class;

    public function mount()
    {
    }

    public function getTextProperty()
    {
        return $this->text;
    }
    public function getNameProperty()
    {
        return $this->name;
    }
    public function getTypeProperty()
    {
        return $this->type;
    }
    public function getLoadingProperty()
    {
        return $this->loading;
    }

    public function getBackProperty()
    {
        return $this->back;
    }

    public function getClickProperty()
    {
        return $this->click;
    }
    public function getClassProperty()
    {
        return $this->class;
    }

}
