<?php

namespace Btw\Core\Libraries;

use Btw\Core\Models\NotificationModel;

class Notifications
{
    public function __construct() {}

    /**
     * Displays all cells that are currently specified in the config.
     */
    public function store($type, $object)
    {
        log_message('info', 'Notification {$type} : {object}', ['object' => $type, 'object' => json_encode($object, JSON_UNESCAPED_SLASHES)]);

        $notifications = new NotificationModel();

        $notifications->insert([
            'user_id' => Auth()->user()->id,
            'type_id' => 1,
            'title' => $type,
            'is_read' => 1,
            'body' => $object->titre,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this;
    }

    public function getIsNotRead(int $limit)
    {
        $notificationModel = new NotificationModel();
        $notifications = $notificationModel->where('is_read', 1)->orderBy('id DESC')->findAll(5);
        return $notifications;
    }
}
