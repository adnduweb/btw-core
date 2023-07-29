<?php

namespace Btw\Core\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Btw\Core\Models\CurrencyModel;

class CurrenciesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * php spark db:seed Btw\\Core\\Database\\Seeds\\CurrenciesSeeder
     *
     * @return void
     */
    public function run()
    {
        
        if (count(model(CurrencyModel::class)->findAll())){ return; }

       $this->db->table('currencies')->insert(['id' => 1,'code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => '$', 'placement' => 'before', 'decimal' => '.', 'thousands' => ',', 'created_at' => date('Y-m-d H:i:s') ]);
       $this->db->table('currencies')->insert(['id' => 2,'code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => '$', 'placement' => 'before', 'decimal' => '.', 'thousands' => ',', 'created_at' => date('Y-m-d H:i:s') ]);
       $this->db->table('currencies')->insert(['id' => 3,'code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'placement' => 'before', 'decimal' => '.', 'thousands' => ',', 'created_at' => date('Y-m-d H:i:s') ]);
       $this->db->table('currencies')->insert(['id' => 4,'code' => 'GBP', 'name' => 'Pound Sterling', 'symbol' => '£', 'placement' => 'before', 'decimal' => '.', 'thousands' => ',', 'created_at' => date('Y-m-d H:i:s') ]);
       $this->db->table('currencies')->insert(['id' => 5,'code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'placement' => 'before', 'decimal' => '.', 'thousands' => ',', 'created_at' => date('Y-m-d H:i:s') ]);

    }
}
