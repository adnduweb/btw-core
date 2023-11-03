<?php

namespace Btw\Core\Cells;

class StatsDashboardCells
{
    protected $result;
    protected $notes;
    /**
     * Displays the stat blocks in the admin dashboard.
     */
    public function render()
    {
        return view('Btw\Core\Views\Admin\dashboard\init', [ ]);
    }

    public function scripts()
    {
        return view('Btw\Core\Views\Admin\dashboard\init_scripts', [ ]);
    }
}
