# btw-core
module core Ci4

# Installation

    composer create-project codeigniter4/appstarter my-app

Ajouter dans le fichier composer.json à la racine de votre projet.

    composer config minimum-stability dev
    composer config prefer-stable true

Mofification SQL si besoin

    Changez le moteur de stockage utilisé par défaut pour que les nouvelles tables soient toujours créées correctement:
        set GLOBAL storage_engine='InnoDb'; 
    Pour MySQL 5.6 et versions ultérieures, utilisez les éléments suivants:
        SET GLOBAL default_storage_engine = 'InnoDB';

Installer le package

    composer require adnduweb/btw-core:dev-develop

    php spark btw:install
    php spark btw:install -- continue
    php spark vite:init
    npm install
    npx tailwindcss init -p

# Lancement de l'application
    php spark serve
    npm run dev


# Inspirations
https://demo.cartify.dev/admin/settings
https://www.patreon.com/lonnieezell/posts
https://demo.ticksify.com/agent/login
https://viewi.net/docs/integrations-code-igniter4
https://demos.creative-tim.com/notus-react/?_ga=2.243129153.299807871.1676216059-1015485538.1676124710#/admin/settings
https://rappasoft.com/blog/snippet-5-creating-a-simple-but-cool-delete-button-with-alpinejs-and-tailwindcss
https://django-htmx-alpine.nicholasmoen.com/tasks/
https://htmx.org/extensions/web-sockets/
https://tailwindcomponents.com/component/password-generator-and-strength-score
gestiond es erreurs -> alpinejs & htmx -> https://github.com/alpinejs/alpine/discussions/2916
https://github.com/datamweb/shield-oauth
https://github.com/hermawanramadhan/CodeIgniter4-DataTables
composer require michalsn/codeigniter4-uuid
https://blog.benoitblanchon.fr/django-htmx-messages-framework/
https://til.jacklinke.com/using-htmx-and-server-side-datatables-net-together-in-a-django-project
https://www.youtube.com/watch?v=Q9eynRwc1CA
https://blog.benoitblanchon.fr/django-htmx-toasts/
https://windstatic.com/
https://vemto.app/blog/how-to-create-an-image-upload-viewer-with-alpinejs
https://alpinejs.dev/component/date-range-picker
https://github.com/anggadarkprince/ci4-services

# Aide
https://forum.codeigniter.com/showthread.php?tid=84604
https://stackoverflow.com/questions/75424519/sending-a-value-from-jquery-to-alpinejs
https://codepen.io/yuxufm/pen/YzLoxvE => add/delete clone
https://stackoverflow.com/questions/69197458/dynamically-add-new-rows-to-the-table => pareil mais en mieux
https://pastebin.com/kupzmyx3 -> CRSF
https://forum.codeigniter.com/showthread.php?tid=87720 -> envoi un mail aux nouveaux comptes
https://forum.codeigniter.com/showthread.php?tid=87719 -> information supplémentaires (adresses)
https://forum.codeigniter.com/showthread.php?tid=87702 -> Tableau des permissisons

## Jointure

$db      = \Config\Database::connect();
$builder = $db->table('payments p');
$builder->select('*');
$builder->join('flats f', 'f.flat_id = p.flat_id', 'left');
$builder->join('users u', 'u.user_id = f.owner_id', 'left');
$builder->groupBy('name');
$query = $builder->get();
$data['table_joined'] = $query->getResult(); 