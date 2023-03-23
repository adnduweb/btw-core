<?php

namespace Btw\Core\Models;

use CodeIgniter\Model;
use Btw\Core\Entities\Activity;

class ActivityModel extends Model
{
    protected $table          = 'activity_log';
    protected $primaryKey     = 'id';
    protected $returnType     = Activity::class;
    protected $useTimestamps  = false;
    protected $useSoftDeletes = false;
    protected $skipValidation = true;
    protected $allowedFields  = ['source', 'source_id', 'user_id', 'event', 'summary', 'properties', 'created_at'];


    protected $columns = [
        ['name' => 'selection'],
        ['name' => 'source', 'orderable' => true, 'header' => 'Source', 'order_by_source' => 'DESC'],
        ['name' => 'source_id', 'orderable' => true, 'header' => 'Source ID', 'order_by_source_id' => 'DESC'],
        ['name' => 'user_id', 'orderable' => true, 'header' => 'User ID', 'order_by_user_id' => 'DESC'],
        ['name' => 'event', 'orderable' => true, 'header' => 'Event', 'order_by_event' => 'DESC'],
        ['name' => 'summary', 'orderable' => true, 'header' => 'Summary', 'order_by_summary' => 'DESC'],
        ['name' => 'properties', 'orderable' => true, 'header' => 'Properties', 'order_by_properties' => 'DESC'],
        ['name' => 'created_at', 'orderable' => true, 'header' => 'created_at', 'order_by_email' => 'DESC'],
        ['name' => 'action', 'header' => 'Action', 'order_by_alias' => NULL]

    ];

    public function getColumn()
    {
        return $this->columns;
    }
}
