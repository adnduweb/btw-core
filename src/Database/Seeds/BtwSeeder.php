<?php

namespace Btw\Core\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Btw\Core\Commands\Install\Publisher;

class BtwSeeder extends Seeder
{
    public function run()
    {

        $twig = WRITEPATH . 'cache' . DIRECTORY_SEPARATOR . 'twig';
        if (!is_dir($twig) && !@mkdir($twig, 0775, true)) {
            throw new \Exception('impossible de créer le dossier twig');
        }

        service('settings')->set('Btw.themebo', 'Admin');
        service('settings')->set('Btw.siteName', 'La meilleur Appli du monde');
        service('settings')->set('Btw.titleNameAdmin', 'ADN du Web');
        service('settings')->set('Btw.siteOnline', true);
        service('settings')->set('App.appTimezone', 'Europe/Paris');
        service('settings')->set('App.dateFormat', 'Y-m-d');
        service('settings')->set('App.timeFormat', 'H:i');
        service('settings')->set('Btw.language_bo', 'fr');
        service('settings')->set('Auth.allowRegistration', false);
        service('settings')->set('AuthGroups.defaultGroup', 'admin');

        //EMAIL
        service('settings')->set('Email.fromName', 'Appli de malade HTMX');
        service('settings')->set('Email.fromEmail', 'fabrice@adnduweb.com');
        service('settings')->set('Email.protocol', 'mail');
        service('settings')->set('Email.mailPath', '/usr/sbin/sendmail');

        //Storage
        service('settings')->set('Storage.sizeImg', config('Storage')->sizeImg);

        // OAUTH
        service('settings')->set('ShieldOAuthConfig.allow_login', false);
        service('settings')->set('ShieldOAuthConfig.allow_register', false);

        //Company
        service('settings')->set('Btw.seuilMEArtisans', '36800');
        service('settings')->set('Btw.seuilMECommercants', '91900');

        //Search
        $cellsearch = service('settings')->get('Search.cellsearch');
        if (!empty($cellsearch)) {
            $cellsearch = array_merge($cellsearch, ['Btw\Core\Cells\SearchCells::search']);
            $cellsearch = array_unique($cellsearch);
            service('settings')->set('Search.cellsearch', $cellsearch);
        } else {
            service('settings')->set('Search.cellsearch', ['Btw\Core\Cells\SearchCells::search']);
        }

        //Update themes
        $this->publishThemes();
    }
    private function publishThemes()
    {
        $source      = BTPATH . 'configurations/themes';
        $destination = APPPATH . '../themes';

        $sourcePublic      = BTPATH . 'configurations/public';
        $destinationPublic = APPPATH . '../public';

        $admin = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'admin';
        if (!is_dir($admin) && !@mkdir($admin, 0775, true)) {
            throw new \Exception('impossible de créer le dossier admin');
        }

        $front = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'front';
        if (!is_dir($front) && !@mkdir($front, 0775, true)) {
            throw new \Exception('impossible de créer le dossier front');
        }

        $front_img = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'front' . DIRECTORY_SEPARATOR . 'img';
        if (!is_dir($front_img) && !@mkdir($front_img, 0775, true)) {
            throw new \Exception('impossible de créer le dossier front/img');
        }

        $publisher = new Publisher();
        $publisher->copyDirectory($source, $destination);
        $publisher->copyDirectory(BTPATH . 'configurations/package.json', APPPATH . '../package.json');
        $publisher->copyDirectory(BTPATH . 'configurations/vite.admin.config.js', APPPATH . '../vite.admin.config.js');
        $publisher->copyDirectory(BTPATH . 'configurations/vite.front.config.js', APPPATH . '../vite.front.config.js');
        $publisher->copyDirectory(BTPATH . 'configurations/tailwind.admin.config.js', APPPATH . '../tailwind.admin.config.js');
        $publisher->copyDirectory(BTPATH . 'configurations/tailwind.front.config.js', APPPATH . '../tailwind.front.config.js');

        //Dir Public
        $publisher->copyDirectory($sourcePublic, $destinationPublic);
    }
}
