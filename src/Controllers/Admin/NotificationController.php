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
use Btw\Core\Models\NotificationModel;

class NotificationController extends AdminController
{
    protected $theme      = 'admin';
    protected $viewPrefix = 'Btw\Core\Views\Admin\\notifications\\';


    /**
    * Displays basic information about the site.
    *
    * @return string
    */
    public function updateList()
    {
        $notifications = model(NotificationModel::class);
        $notifications = $notifications->where('is_read', 1)->findAll(5);
        return view('Themes\admin\partials\_notify', [
            'notifications' => $notifications
        ]);

    }


    public function streamWebsoket()
    {

        // // Définit le type de contenu SSE
        // header('Content-Type: text/event-stream');
        // header('Cache-Control: no-cache');

        // // Envoie un message toutes les 5 secondes
        // $data = [
        //     'message' => 'Message du serveur via SSE à ' . date('H:i:s')
        // ];

        // echo "data: " . json_encode($data) . "\n\n";
        // ob_flush();
        // flush();

        // Set the appropriate headers for SSE
        $this->response->setContentType('text/event-stream');
        $this->response->setHeader('Cache-Control', 'no-cache')
            ->setHeader('Connection', 'keep-alive')
            ->setHeader('Access-Control-Allow-Origin', base_url())
            ->setHeader('Access-Control-Allow-Methods', 'GET');

        // data to be sent
        $data = [
            'timestamp' => time()
        ];
        $sse_data = "retry: 5000\ndata: " . json_encode($data) . "\n\n";

        // Send the SSE data to the client
        $this->response->appendBody($sse_data);
        $this->response->send();

    }
}
