<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;

class Company extends Entity
{
    protected $table      = 'companies';
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
}
