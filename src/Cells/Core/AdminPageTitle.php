<?php

namespace Btw\Core\Cells\Core;

use CodeIgniter\View\Cells\Cell;

class AdminPageTitle extends Cell
{
    protected string $view = 'admin_page_title';
    protected string $message;
    public array $add;

    public function mount()
    {
        $this->message = ucfirst($this->message);
    }

    public function getMessageProperty(): string
    {
        return $this->message;
    }

    public function getAddProperty(): array
    {
        return $this->add;
    }
}
