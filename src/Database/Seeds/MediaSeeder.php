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

		$s3 = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'placeholder';
		if (!is_dir($s3) && !@mkdir($s3, 0775, true)) {
			throw new \Exception('impossible de créer le dossier placeholder');
		}

		service('settings')->set('Storage.perPage', 8);
		service('settings')->set('Storage.filesFormat', 'cards');
		service('settings')->set('Storage.filesSort', 'file_name');
		service('settings')->set('Storage.filesOrder', 'desc');

		$this->createPlaceholder();
	}

	public function createPlaceholder()
	{

		$basePath = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR .  'placeholder'. DIRECTORY_SEPARATOR ;
		$file = new \CodeIgniter\Files\File(BTPATH . 'Views/Medias/placeholder.webp');
		$ext = $file->guessExtension();

		// Diffrente taille
		if ($sizeImg = config('Storage')->sizeImg) {

			service('image')->withFile($file->getPathName())
					->save(($basePath .  'placeholder.webp'));
			$i = 0;
			foreach ($sizeImg as $item) {
				service('image')->withFile($file->getPathName())
					->fit($item[0], $item[1], $item[2])
					->save(($basePath .  str_replace('.' . $ext, '-' . $item[0] . 'x' . $item[1] . '.' . $ext, 'placeholder.webp')));
				$i++;
			}
		}
	}
}
