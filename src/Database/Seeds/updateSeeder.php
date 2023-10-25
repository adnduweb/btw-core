<?php

namespace Btw\Core\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Btw\Core\Commands\Install\Publisher;

class updateSeeder extends Seeder
{
    public function run()
    {

        //Search
        $cellsearch = service('settings')->get('Search.cellsearch');
        if (!empty($cellsearch)) {
            $cellsearch = array_merge($cellsearch, ['Btw\Core\Cells\SearchCells::search']);
            $cellsearch = array_unique($cellsearch);
            service('settings')->set('Search.cellsearch', $cellsearch);
        } else {
            service('settings')->set('Search.cellsearch', ['Btw\Core\Cells\SearchCells::search']);
        }
    }

}
