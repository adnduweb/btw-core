<?php

namespace Btw\Core\Models;

use CodeIgniter\Model;
use Btw\Core\Entities\Company;

class CompanyModel extends Model
{
    protected $table         = 'companies';
    protected $primaryKey    = 'id';
    protected $returnType    = Company::class;
    protected $useTimestamps = true;
    protected $allowedFields = [
        'uuid',
        'user_id',
        'code_client',
        'country',
        'state',
        'company',
        'lastname',
        'firstname',
        'address1',
        'address2',
        'postcode',
        'city',
        'phone',
        'phone_mobile',
        'vat_number',
        'siret',
        'ape',
        'logo',
        'active',
        'order',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $validationRules = [];
}
