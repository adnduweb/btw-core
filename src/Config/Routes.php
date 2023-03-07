<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */


// Authentication Routes that override Shield's
$routes->group('', ['namespace' => '\Btw\Core\Controllers'], static function ($routes) {
    $routes->get('register', 'RegisterController::registerView');
    $routes->post('register', 'RegisterController::registerAction');
    $routes->get('login', 'LoginController::loginView', ['as' => 'login']);
    $routes->post('login', 'LoginController::loginAction');
    $routes->get('login/magic-link', 'MagicLinkController::loginView', ['as' => 'magic-link']);
    $routes->post('login/magic-link', 'MagicLinkController::loginAction');
    $routes->get('login/verify-magic-link', 'MagicLinkController::verify', ['as' => 'verify-magic-link']);
});

service('auth')->routes($routes, ['except' => ['login', 'register']]);


// Btw Admin routes
$routes->group(ADMIN_AREA, ['namespace' => '\Btw\Core\Controllers\Admin'], static function ($routes) {
    $routes->get('/', 'DashboardController::index', ['as' => 'dashboard']);
    $routes->match(['get', 'post'], 'settings/general', 'GeneralSettingsController::sectionGeneral', ['as' => 'settings-general']);
    $routes->get('settings/timezones', 'GeneralSettingsController::getTimezones');
    $routes->match(['get', 'post'], 'settings/registration-login', 'GeneralSettingsController::sectionRegistrationLogin', ['as' => 'settings-registration']);
    $routes->match(['get', 'post'], 'settings/passwords', 'GeneralSettingsController::sectionPasswords', ['as' => 'settings-passwords']);
    $routes->match(['get', 'post'], 'settings/avatar', 'GeneralSettingsController::sectionAvatar', ['as' => 'settings-avatar']);
    $routes->match(['get', 'post'], 'settings/email', 'GeneralSettingsController::sectionEmail', ['as' => 'settings-email']);
   

    // User Settings
    $routes->match(['get', 'post'], 'settings/user', 'UserSettingsController::editUserCurrent', ['as' => 'user-current-settings']);
    $routes->post('settings/users', 'UserSettingsController::save', ['as' => 'user-settings-save']);
    // Manage Users
    $routes->match(['get', 'post'], 'users', 'UserController::list', ['as' => 'user-list']);
    $routes->get('user/update', 'UserSettingsController::update', ['as' => 'user-update']);
    $routes->get('user/update-group', 'UserSettingsController::updateGroup', ['as' => 'user-update-group']);
    

    $routes->get('groups', 'GroupsController::index', ['as' => 'groups-list']);
    $routes->get('groups/show/(:any)', 'GroupsController::show/$1', ['as' => 'group-show']);
    $routes->post('groups/save', 'GroupsController::saveGroup', ['as' => 'group-save']);
    $routes->delete('groups/delete/(:any)', 'GroupsController::delete/$1', ['as' => 'group-delete']);

    $routes->get('permissions', 'PermissionsController::index', ['as' => 'permissions-list']);
    $routes->get('permissions/add', 'PermissionsController::add', ['as' => 'permissions-add']);
    $routes->get('permissions/show/(:any)', 'PermissionsController::show/$1', ['as' => 'group-show']);
    $routes->post('permissions/save', 'PermissionsController::saveGroup', ['as' => 'group-save']);
    $routes->delete('permissions/delete/(:any)', 'PermissionsController::delete/$1', ['as' => 'group-delete']);
    
});
