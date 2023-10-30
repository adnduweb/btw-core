<?php

namespace Btw\Core\Cells;

use Btw\Core\Models\NoteModel;

class StatsDashbardCells
{
    protected $result;
    protected $notes;
    /**
     * Displays the stat blocks in the admin dashboard.
     */
    public function init()
    {
      

        return view('Btw\Core\Views\Admin\dashboard\cells\init', [
            'notes' => $this->notes,
        ]);
    }
}
