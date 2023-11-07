<?php

namespace Btw\Core\Models;

use CodeIgniter\Model;
use Btw\Core\Entities\Notification;

class NotificationModel extends Model
{
    protected $table           = 'notify';
    protected $without         = [];
    protected $primaryKey      = 'id';
    protected $returnType      = Notification::class;
    protected $useSoftDeletes  = true;
    protected $allowedFields    = ['user_id', 'title', 'is_read', 'body'];
    protected $useTimestamps   = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

}
