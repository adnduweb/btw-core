<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Controllers\Admin;

use Btw\Core\Controllers\AdminController;
use Bonfire\Dashboard\CellManager;

/**
 * Class Dashboard
 *
 * The primary entry-point to the Bonfire admin area.
 */
class WidgetsController extends AdminController
{

    protected string $baseURL = 'admin/widgets';
    protected $viewPrefix = 'Btw\Core\Views\Admin\widgets\\';

    /**
     * Displays the stat blocks in the admin dashboard.
     */
    public function chart_view_hx()
    {

        $period = request()->getGet("period") ?? 'week';
        $chart_id = request()->getGet("chart_id");
        $chart_type = request()->getGet("chart_type");

        // chart_title = CHART_TYPES.get(chart_type, "page_views")

        $days_in_period = [
            "week" => 7,
            "month" => 30,
        ];

        $filter_by = $days_in_period[$period];

        if ($period == 'week') {
            $data = [
                'xAxis' => ['data' => ['shirt', 'cardigan', 'chiffon', 'pants', 'heels', 'socks']],
                'series' => ['data' => [200, 45, 36, 150, 24, 12]]
            ];
        } else {
            $data = [
                'xAxis' => ['data' => ['shirt', 'cardigan', 'chiffon', 'pants', 'heels', 'socks']],
                'series' => ['data' => [165, 20, 36, 10, 10, 20]]
            ];
        }

        // if ($request->ajax()
        response()->triggerClientEvent('swap', [json_encode($data)]);
        return view($this->viewPrefix . 'index', [
            'data' => $data
        ]);

    }

    /**
     * Displays the stat blocks in the admin dashboard.
     */
    public function chart_view_hx_update()
    {

        $period = $this->request->getGet("period") ?? 'week';
        $chart_id = $this->request->getGet("chart_id");
        $chart_type = $this->request->getGet("chart_type");

        // chart_title = CHART_TYPES.get(chart_type, "page_views")

        $days_in_period = [
            "week" => 7,
            "month" => 30,
        ];

        $filter_by = $days_in_period[$period];

        if ($period == 'week') {
            $data = [
                'xAxis' => ['data' => ['shirt', 'cardigan', 'chiffon', 'pants', 'heels', 'socks']],
                'series' => ['data' => [5, 45, 36, 150, 24, 12]]
            ];
        } else {
            $data = [
                'xAxis' => ['data' => ['shirt', 'cardigan', 'chiffon', 'pants', 'heels', 'socks']],
                'series' => ['data' => [5, 20, 36, 10, 32, 20]]
            ];
        }

        $data['id'] = "charts";

        // $this->response->triggerClientEvent('swap', [json_encode($data)]);
        return $this->response->setJSON($data);
    }
}