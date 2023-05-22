<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;

class Media extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
