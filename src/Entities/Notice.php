<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;

class Notice extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    /**
     * Renders Datatable Identifier primary
     *
     * @return int
     */
    public function getIdentifier()
    {
        return $this->attributes['id'] ?? null;
    }

}
