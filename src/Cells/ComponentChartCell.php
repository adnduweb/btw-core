<?php

// app/Cells/AlertMessageCell.php
namespace Btw\Core\Cells;

use CodeIgniter\View\Cells\Cell;

class ComponentChartCell extends Cell
{
    protected $type;
    protected $message;
    private $computed;

    public function mount()
    {
        $this->computed = sprintf('%s - %s', $this->type, $this->message);
    }

    public function getComputedProperty(): string
    {
        return $this->computed;
    }

    public function getTypeProperty(): string
    {
        return $this->type;
    }

    public function getMessageProperty(): string
    {
        return $this->message;
    }
}