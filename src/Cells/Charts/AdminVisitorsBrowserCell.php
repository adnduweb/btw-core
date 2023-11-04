<?php

namespace Btw\Core\Cells\Charts;

use CodeIgniter\View\Cells\Cell;
use Btw\Core\Models\VisitModel;
use InvalidArgumentException;

class AdminVisitorsBrowserCell extends Cell
{
    protected string $view = 'admin_visitors_browser';
    protected array $allBrowser;

    public function mount()
    {
        $model = model(VisitModel::class);

        $model->select('id, session_id, user_agent');
        $model->distinct();
        $allVisits = $model->findAll();



        $arrayVisit = [];
        if ($allVisits) {
            $i = 0;
            foreach ($allVisits as $row) {
                if ($row->agent->device->type != "bot") {
                    $arrayVisit[$row->agent->browser->name][$row->session_id] = $row->id;
                }
                $i++;
            }
        }

        return $this->allBrowser = $arrayVisit;
    }

    protected function getAllBrowserProperty(): array
    {
        return $this->allBrowser;
    }
}
