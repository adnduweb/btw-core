<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;

class Tax extends Entity
{
    protected $table      = 'tax';
    protected $datamap = [];

    /**
     * Define properties that are automatically converted to Time instances.
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    /**
     * Array of field names and the type of value to cast them as
     * when they are accessed.
     */
    protected $casts = [];
}
