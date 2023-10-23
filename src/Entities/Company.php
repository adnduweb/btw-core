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

    protected $attributes = [
        'uuid' => null,
        'user_id' => null,
        'code_client' => null,
        'country' => 'FR',
        'state' => null,
        'currency_code' => 3,
        'type_company' => 1,
        'company' => null,
        'lastname' => null,
        'firstname' => null,
        'email' => null,
        'address1' => null,
        'address2' => null,
        'postcode' => null,
        'city' => null,
        'phone' => null,
        'phone_mobile' => null,
        'vat_number' => null,
        'siret' => null,
        'ape' => null,
        'logo' => null,
        'active' => null,
        'order' => null,
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
