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

        //Update themes
        $this->publishThemes();
    }
    private function publishThemes()
    {
        $source      = BTPATH . '../themes';
        $destination = APPPATH . '../themes';

        $publisher = new Publisher();
        $publisher->copyDirectory($source, $destination);

        //logo
        $publisher->copyDirectory(BTPATH . '../themes/Admin/img/logo-adn.png', APPPATH . '../public/admin/img/logo-adn.png');
        $publisher->copyDirectory(BTPATH . '../themes/Admin/img/logo-adn-grey.png', APPPATH . '../public/admin/img/logo-adn-grey.png');
        $publisher->copyDirectory(BTPATH . '../themes/Admin/img/logo-adn-grey.png', APPPATH . '../public/admin/img/logo-adn-grey.png');
        $publisher->copyDirectory(BTPATH . '../themes/Admin/img/logo-adn-small.png', APPPATH . '../public/admin/img/logo-adn-small.png');
    }
}
