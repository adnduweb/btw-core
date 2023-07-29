<?php

namespace Btw\Core\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Btw\Core\Models\TaxModel;

class TaxesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * php spark db:seed Btw\\Core\\Database\\Seeds\\TaxesSeeder
     *
     * @return void
     */
    public function run()
    {

        if (count(model(TaxModel::class)->findAll())) {
            return;
        }

        $this->db->table('tax')->insert(['id' => 1, 'rate' => '20.000', 'active' => 1, 'created_at' => date('Y-m-d H:i:s')]);
        $this->db->table('tax')->insert(['id' => 2, 'rate' => '21.000', 'active' => 1, 'created_at' => date('Y-m-d H:i:s')]);

        $this->db->table('tax_langs')->insert(['id_tax_lang' => 1, 'tax_id' => 1, 'lang' => 'fr', 'name' => 'FR Taux standard (20%)']);
        $this->db->table('tax_langs')->insert(['id_tax_lang' => 2, 'tax_id' => 1, 'lang' => 'fr', 'name' => 'TVA BE 21%']);

        $this->db->table('tax_rules_group')->insert(['id_tax_rules_group' => 1, 'name' => 'FR Taux standard (20%)', 'active' => 1, 'created_at' => date('Y-m-d H:i:s')]);
        $this->db->table('tax_rules_group')->insert(['id_tax_rules_group' => 2, 'name' => 'FR Taux réduit (5.5%)', 'active' => 1, 'created_at' => date('Y-m-d H:i:s')]);

        $this->db->table('tax_rules')->insert(['id_tax_rule' => 1,  'country' => 'FR', 'state' => '', 'id_tax_rules_group' => '1', 'tax_id' => 1,  'created_at' => date('Y-m-d H:i:s')]);
        $this->db->table('tax_rules')->insert(['id_tax_rule' => 2,  'country' => 'BE', 'state' => '', 'id_tax_rules_group' => '1', 'tax_id' => 2,  'created_at' => date('Y-m-d H:i:s')]);
    }
}
