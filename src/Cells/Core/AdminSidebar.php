<?php

namespace Btw\Core\Cells\Core;

use CodeIgniter\View\Cells\Cell;

class AdminSidebar extends Cell
{
    protected string $view = 'admin_sidebar_cell';

    public $menu = [];
    public string $currentUrl;

    public function mount()
    {
        $this->menu = service('menus')->menu('sidebar');
        $this->currentUrl = request()->getUri()->getPath();
    }
}