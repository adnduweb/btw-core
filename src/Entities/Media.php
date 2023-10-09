<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;

class Media extends Entity
{
    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];

    protected $attributes = [
        'id' => null,
        'uuid' => null,
        'disk' => 'disk',
        'type' => '',
        'size' => '',
        'path' => '',
        'file_name' => '',
        'file_path' => '',
        'file_url' => '',
        'full_path' => '',
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null,
    ];

    /**
     * Renders Datatable Identifier primary
     *
     * @return int
     */
    public function getIdentifier()
    {
        if (isset($this->attributes['identifier'])) {
            return $this->attributes['identifier'] ?? null;
        } else {
            return $this->attributes['id'] ?? null;
        }
    }

    /**
     * Renders Identifier UUID
     *
     * @return int
     */
    public function getIdentifierUUID()
    {
        return $this->attributes['uuid'] ?? null;
    }

    public function getFileUrl()
    {
        return $this->attributes['file_url'] ?? 'https://images.unsplash.com/photo-1531316282956-d38457be0993?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=80';
    }

    public function getAlt()
    {
        return isset($this->attributes['legend']) ? $this->attributes['legend'] : null;
    }

    public function getTitle()
    {
        return isset($this->attributes['titre']) ? $this->attributes['titre'] : null;
    }
}
