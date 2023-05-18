<?php

namespace Btw\Core\Models;

use CodeIgniter\Model;

class LogsModel extends Model
{
    protected $table          = 'logs';
    protected $primaryKey     = 'id';
    protected $returnType     = 'object';
    protected $useTimestamps  = false;
    protected $useSoftDeletes = false;
    protected $skipValidation = true;
    protected $allowedFields  = ['event_type', 'event_access', 'data', 'created_by', 'created_at'];

    public function insertLog(array $data){

        // if (function_exists('auth')) {
        //     $user_id = (!empty(auth()->user()->id)) ? auth()->user()->id : null;
        // } else {
            $user_id = null;
        // }

        $data['created_by'] = $user_id;
        $data['created_at'] = date('Y-m-d H:i:s');

       $this->db->table('logs')->insert($data);

    }
}
