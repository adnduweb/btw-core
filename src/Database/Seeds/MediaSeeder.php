<?php

namespace Btw\Core\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MediaSeeder extends Seeder
{
	public function run()
	{

		$public = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'public';
		if (!is_dir($public) && !@mkdir($public, 0775, true)) {
			throw new \Exception('impossible de créer le dossier public');
		}

		$local = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'local';
		if (!is_dir($local) && !@mkdir($local, 0775, true)) {
			throw new \Exception('impossible de créer le dossier local');
		}

		$s3 = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 's3';
		if (!is_dir($s3) && !@mkdir($s3, 0775, true)) {
			throw new \Exception('impossible de créer le dossier s3');
		}

		service('settings')->set('Storage.perPage', 8);

		service('settings')->set('Storage.filesFormat', 'cards');

		service('settings')->set('Storage.filesSort', 'filename');

		service('settings')->set('Storage.filesOrder', 'asc');
	}
}
