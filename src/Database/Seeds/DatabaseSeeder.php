<?php

namespace Btw\Core\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call('Btw\Core\Database\Seeds\BtwSeeder');
        $this->call('Btw\Core\Database\Seeds\MediaSeeder');
        $this->call('Btw\Core\Database\Seeds\CurrenciesSeeder');
        $this->call('Btw\Core\Database\Seeds\TaxesSeeder');        
        $this->call('Btw\Core\Database\Seeds\CompanySeeder');    

    }
}
