<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */

 $routes->get('assets/(:any)', '\Btw\Core\Controllers\AssetController::serve/$1');


// Authentication Routes that override Shield's
$routes->group('', ['namespace' => '\Btw\Core\Controllers\Auth'], static function ($routes) {
    $routes->get('register', 'RegisterController::registerView');
    $routes->post('register', 'RegisterController::registerAction');
    $routes->get('login', 'LoginController::loginView', ['as' => 'login']);
    $routes->post('login', 'LoginController::loginAction');
    $routes->get('login/magic-link', 'MagicLinkController::loginView', ['as' => 'magic-link']);
    $routes->post('login/magic-link', 'MagicLinkController::loginAction');
    $routes->get('login/verify-magic-link', 'MagicLinkController::verify', ['as' => 'verify-magic-link']);
    $routes->get('auth/a/show', 'ActionController::show', ['as' => 'auth-action-show']);
    $routes->post('auth/a/handle', 'ActionController::handle', ['as' => 'auth-action-handle']);
    $routes->post('auth/a/verify', 'ActionController::verify', ['as' => 'auth-action-verify']);
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
    $routes->match(['get', 'post'], 'settings/user/history', 'UserSettingsController::history', ['as' => 'user-history']);
    $routes->match(['get', 'post'], 'settings/user/browser', 'UserSettingsController::sessionBrowser', ['as' => 'user-session-browser']);
    $routes->match(['get', 'post'], 'settings/user/capabilities', 'UserSettingsController::capabilities', ['as' => 'user-capabilities']);
    $routes->put('settings/user/capabilities/toggle/(:any)', 'UserSettingsController::toggle/$1', ['as' => 'user-permissions-toggle-only']);
    $routes->put('settings/user/capabilities/toggle-all', 'UserSettingsController::toggleAll', ['as' => 'user-permissions-toggle-all']);
    $routes->match(['get', 'post'], 'settings/user/change-password', 'UserSettingsController::changePassword', ['as' => 'user-change-password']);
    $routes->match(['get', 'post'], 'settings/user/two-factor', 'UserSettingsController::twoFactor', ['as' => 'user-two-factor']);



    $routes->match(['get', 'post'], 'logs/files/list', 'ActivityController::logsFile', ['as' => 'logs-file']);



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
