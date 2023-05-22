<?php

namespace Btw\Core\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BtwSeeder extends Seeder
{
	public function run()
	{
		service('settings')->set('Btw.themebo', 'Admin');
		service('settings')->set('Site.siteName', '"La meilleur Appli du monde');
		service('settings')->set('Site.siteOnline', true);
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

	}
}
