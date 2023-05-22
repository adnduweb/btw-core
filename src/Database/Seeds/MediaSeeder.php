<?php

namespace Btw\Core\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MediaSeeder extends Seeder
{
	public function run()
	{
		service('settings')->set('Storage.perPage', 8);

		service('settings')->set('Storage.filesFormat', 'cards');

		service('settings')->set('Storage.filesSort', 'filename');
		
		service('settings')->set('Storage.filesOrder', 'asc');
	}
}
