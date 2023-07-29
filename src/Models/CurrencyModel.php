<?php

namespace Btw\Core\Models;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use Btw\Core\Entities\Currency;

class CurrencyModel extends Model
{
    protected $table         = 'currencies';
    protected $primaryKey    = 'id';
    protected $returnType    = Currency::class;
    protected $useTimestamps = true;
    protected $allowedFields = [
        'code',
        'name',
        'symbol',
        'placement',
        'decimal',
        'thousands'
    ];
    protected $validationRules = [];
}
