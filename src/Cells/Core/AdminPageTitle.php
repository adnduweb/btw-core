<?php

namespace Btw\Core\Cells\Core;

use CodeIgniter\View\Cells\Cell;

class AdminPageTitle extends Cell
{
    protected string $view = 'admin_page_title';
    public string $message;
    public array $add;

    public function mount(string $message, array $add = [])
    {
        $this->message = ucfirst($message);
        $this->add = $add;
    }
}