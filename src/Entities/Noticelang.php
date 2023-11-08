<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;

class Noticelang extends Entity
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
        return $this->attributes['notice_id'] ?? null;
    }

}
