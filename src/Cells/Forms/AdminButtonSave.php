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
    protected $xtext;

    public function mount()
    {
        if(!empty($this->xtext)) {
            $this->xtext = 'x-text="' . $this->xtext . '"';
        }

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
    public function getXtextProperty()
    {
        return $this->xtext;
    }

}
