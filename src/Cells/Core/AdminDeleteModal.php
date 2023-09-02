<?php

namespace Btw\Core\Cells\Core;

use CodeIgniter\View\Cells\Cell;

class AdminDeleteModal extends Cell
{
    protected string $view = 'admin_delete_modal';
    public array $group;

    public function mount(array $group)
    {
        $this->group = $group;
    }
}