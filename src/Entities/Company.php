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

    protected $attributes = [];


    /**
     * Renders Datatable Identifier primary
     *
     * @return int
     */
    public function getIdentifier()
    {
        return $this->attributes['identifier'] ?? null;
    }

    public function getCompany()
    {
        return $this->attributes['company'] ?? null;
    }


    public function getCurrency()
    {
        return $this->attributes['currency_code'] ?? null;
    }

    public function getTypeCompany()
    {
        return $this->attributes['type_company'] ?? null;
    }
}
