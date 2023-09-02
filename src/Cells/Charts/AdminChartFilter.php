<?php

namespace Btw\Core\Cells\Charts;

use CodeIgniter\View\Cells\Cell;

class AdminChartFilter extends Cell
{
    protected string $view = 'admin_chart_filter';
    public string $period;
    public string $route;
    public string $selected;
    public string $type;
    public string $label;

    public function mount(string $period, string $route, string $selected, string $type, string $label)
    {
        $this->period = $period;
        $this->route = $route;
        $this->selected = $selected;
        $this->type = $type;
        $this->label = $label;
    }
}