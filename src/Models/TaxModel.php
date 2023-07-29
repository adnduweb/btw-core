<?php

namespace Btw\Core\Models;

use CodeIgniter\Model;
use Btw\Core\Entities\Tax;

class TaxModel extends Model
{

    protected $table           = 'tax';
    protected $without         = [];
    protected $primaryKey      = 'id';
    protected $primaryKeyLang  = 'taxe_id';
    protected $returnType      = Tax::class;
    protected $useSoftDeletes  = true;
    protected $allowedFields   = ['rate', 'active'];
    protected $useTimestamps   = true;
    protected $validationRules = [
        'rate'            => 'required'
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getTaxByCountry(string $country)
    {
        $builder = $this->db->table('tax_rules_group');
        $builder->select('*');
        $builder->join('tax_rules', 'tax_rules.id_tax_rules_group = tax_rules_group.id_tax_rules_group');
        $builder->join('tax', 'tax.id = tax_rules.tax_id');
        $builder->where('tax_rules_group.active', 1);
        $builder->where('tax_rules.country', $country);
        $query = $builder->get();

        return $query->getRow();
    }
}
