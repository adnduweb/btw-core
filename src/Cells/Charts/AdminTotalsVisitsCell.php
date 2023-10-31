<?php

namespace Btw\Core\Cells\Charts;

use CodeIgniter\View\Cells\Cell;
use Btw\Core\Models\VisitModel;
use InvalidArgumentException;

class AdminTotalsVisitsCell extends Cell
{
    protected string $view = 'admin_totals_visits';
    protected string $allVisits;

    public function mount()
    {
        $model = model(VisitModel::class);

        $model->select('id, session_id');
        $model->distinct();
        $allVisits = $model->findAll();

        $arrayVisit = [];
        if($allVisits) {
            $i = 0;
            foreach ($allVisits as $row) {
                $arrayVisit[$row->session_id] = $row;
                $i++;
            }
        }
        return $this->allVisits = count($arrayVisit);
    }

    protected function getAllVisitsProperty(): string
    {
        return $this->allVisits;
    }
}
