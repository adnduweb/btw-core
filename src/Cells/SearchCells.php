<?php

namespace Btw\Core\Cells;

use Btw\Core\Models\NoteModel;

class SearchCells
{
    protected $result;
    protected $notes;
    /**
     * Displays the stat blocks in the admin dashboard.
     */
    public function search()
    {
        if (request()->getPost('search')) {
            $this->notes = model(NoteModel::class)->withAskAuth()->searchAll(request()->getPost('search'));
        }

        return view('Btw\Core\Views\Admin\search\cells\form_search', [
            'notes' => $this->notes,
        ]);
    }
}
