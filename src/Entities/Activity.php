<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;

class Activity extends Entity
{
    protected $table      = 'activity_log';
    protected $primaryKey = 'id';
    protected $dates      = ['created_at'];
    protected $casts      = [
        'source_id' => 'int',
        'user_id'   => 'int',
    ];

      /**
     * Renders Datatable Identifier primary
     *
     * @return int
     */
    public function getIdentifier(){
        return $this->attributes['identifier'] ?? null; 
    }

     /**
     * Renders Datatable Url
     *
     * @return string
     */
    public function getUrlEditAdmin(){
       return route_to('log-system-information', $this->attributes['identifier']);
    }
}
