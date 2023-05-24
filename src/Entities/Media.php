<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;

class Media extends Entity
{
    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];

    public function getFileUrl()
    {
        return $this->attributes['file_url'] ?? 'https://images.unsplash.com/photo-1531316282956-d38457be0993?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=80';
    }
}