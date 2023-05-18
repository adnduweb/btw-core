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
    $routes->get('logout', 'LoginController::logoutAction', ['as' => 'logout']);
    $routes->get('login/magic-link', 'MagicLinkController::loginView', ['as' => 'magic-link']);
    $routes->post('login/magic-link', 'MagicLinkController::loginAction');
    $routes->get('login/verify-magic-link', 'MagicLinkController::verify', ['as' => 'verify-magic-link']);
    $routes->get('auth/a/show', 'ActionController::show', ['as' => 'auth-action-show']);
    $routes->post('auth/a/handle', 'ActionController::handle', ['as' => 'auth-action-handle']);
    $routes->post('auth/a/verify', 'ActionController::verify', ['as' => 'auth-action-verify']);
});

service('auth')->routes($routes, ['except' => ['login', 'register']]);

// Authentication Routes that override Shield's Oauth
$routes->group('oauth', ['namespace' => '\Btw\Core\Controllers\Auth'], static function ($routes): void {
    $routes->addPlaceholder('allOAuthList', service('ShieldOAuth')->allOAuth());
    $routes->get('(:allOAuthList)', 'OAuthController::redirectOAuth/$1');

    $routes->get(config('ShieldOAuthConfig')->call_back_route, 'OAuthController::callBack');
});


// Btw Admin routes
$routes->group(ADMIN_AREA, ['namespace' => '\Btw\Core\Controllers\Admin'], static function ($routes) {

    $routes->get('/', 'DashboardController::index', ['as' => 'dashboard']);

    // Settings Gobal
    $routes->match(['get', 'post'], 'settings/general', 'GeneralSettingsController::sectionGeneral', ['as' => 'settings-general']);
    $routes->get('settings/timezones', 'GeneralSettingsController::getTimezones');
    $routes->match(['get', 'post'], 'settings/registration-login', 'GeneralSettingsController::sectionRegistrationLogin', ['as' => 'settings-registration']);
    $routes->match(['get', 'post'], 'settings/passwords', 'GeneralSettingsController::sectionPasswords', ['as' => 'settings-passwords']);
    $routes->match(['get', 'post'], 'settings/avatar', 'GeneralSettingsController::sectionAvatar', ['as' => 'settings-avatar']);
    $routes->match(['get', 'post'], 'settings/email', 'GeneralSettingsController::sectionEmail', ['as' => 'settings-email']);
    $routes->match(['get', 'post'], 'settings/oauth', 'GeneralSettingsController::sectionOauth', ['as' => 'settings-oauth']);

    // Manage Users
    $routes->get('users', 'UsersController::index', ['as' => 'user-list']);
    $routes->get('users/list', 'UsersController::ajaxDatatable', ['as' => 'users-list-ajax']);
    $routes->match(['get', 'post'], 'users/edit/(:any)/information', 'UsersController::edit/$1', ['as' => 'user-only-information']);
    $routes->match(['get', 'post'], 'users/edit/(:any)/capabilities', 'UsersController::capabilities/$1', ['as' => 'user-only-capabilities']);
    $routes->put('users/edit/(:any)/capabilities/toggle/(:any)', 'UsersController::toggle/$1/$2', ['as' => 'users-permissions-toggle-only']);
    $routes->put('users/edit/(:any)/capabilities/toggle-all', 'UsersController::toggleAll/$1', ['as' => 'users-permissions-toggle-all']);
    $routes->match(['get', 'post'], 'users/edit/(:any)/change-password', 'UsersController::changePassword/$1', ['as' => 'user-only-change-password']);
    $routes->match(['get', 'post'], 'users/edit/(:any)/two-factor', 'UsersController::twoFactor/$1', ['as' => 'user-only-two-factor']);
    $routes->match(['get', 'post'], 'users/edit/(:any)/history', 'UsersController::history/$1', ['as' => 'user-only-history']);
    $routes->match(['get', 'post'], 'users/edit/(:any)/browser', 'UsersController::sessionBrowser/$1', ['as' => 'user-only-browser']);
    $routes->delete('users/delete', 'UsersController::deleteUser', ['as' => 'users-delete']);



    // User Current
    $routes->match(['get', 'post'], 'settings/user', 'ProfileController::editUserCurrent', ['as' => 'user-profile-settings']);
    $routes->post('settings/users', 'ProfileController::save', ['as' => 'user-settings-save']);
    $routes->get('user/update', 'ProfileController::update', ['as' => 'user-update']);
    $routes->get('user/update-group/(:any)', 'ProfileController::updateGroup/$1', ['as' => 'user-update-group']);
    $routes->match(['get', 'post'], 'settings/user/history', 'ProfileController::history', ['as' => 'user-history']);
    $routes->match(['get', 'post'], 'settings/user/browser', 'ProfileController::sessionBrowser', ['as' => 'user-session-browser']);
    $routes->match(['get', 'post'], 'settings/user/capabilities', 'ProfileController::capabilities', ['as' => 'user-capabilities']);
    $routes->put('settings/user/capabilities/toggle/(:any)', 'ProfileController::toggle/$1', ['as' => 'user-permissions-toggle-only']);
    $routes->put('settings/user/capabilities/toggle-all', 'ProfileController::toggleAll', ['as' => 'user-permissions-toggle-all']);
    $routes->match(['get', 'post'], 'settings/user/change-password', 'ProfileController::changePassword', ['as' => 'user-change-password']);
    $routes->match(['get', 'post'], 'settings/user/two-factor', 'ProfileController::twoFactor', ['as' => 'user-two-factor']);
    $routes->get('user/update/avatar', 'ProfileController::updateAvatar', ['as' => 'user-update-avatar']);
    $routes->get('user/update/language', 'ProfileController::changeLangue', ['as' => 'user-profile-language']);
    $routes->get('user/update/sidebar-expanded', 'ProfileController::changeSidebarExpanded', ['as' => 'user-profile-sidebarexpanded']);


    // Files Logs
    $routes->get('logs/files/list', 'ActivityController::logsFile', ['as' => 'logs-file']);
    $routes->get('logs/files/(:any)', 'ActivityController::viewFile/$1', ['as' => 'log-file-view']);
    $routes->post('logs/files/delete-all', 'ActivityController::deleteFilesAll', ['as' => 'logs-files-delete-all']);
    $routes->get('logs/system', 'ActivityController::listsystem', ['as' => 'logs-system']);
    $routes->get('logs/sytem', 'ActivityController::ajaxDatatableSystem', ['as' => 'logs-system-ajax']);
    $routes->delete('logs/sytem/delete', 'ActivityController::deleteSystem/$1', ['as' => 'logs-system-delete']);

    //Tools
    $routes->get('systeminfo', 'SystemInfoController::index', ['as' => 'sys-info']);
    $routes->get('php-info', 'SystemInfoController::phpInfo', ['as' => 'sys-phpinfo']);


    // Groups
    $routes->get('groups', 'GroupsController::index', ['as' => 'groups-list']);
    $routes->match(['get', 'post'], 'groups/show/(:any)/information', 'GroupsController::show/$1', ['as' => 'group-show']);
    $routes->match(['get', 'post'], 'groups/show/(:any)/capabilities', 'GroupsController::capabilities/$1', ['as' => 'group-capabilities']);
    $routes->put('groups/capabilities/toggle/(:any)', 'GroupsController::toggle/$1', ['as' => 'group-permissions-toggle-only']);
    $routes->put('groups/capabilities/toggle-all', 'GroupsController::toggleAll', ['as' => 'group-permissions-toggle-all']);
    $routes->match(['get', 'post'], 'groups/add', 'GroupsController::create', ['as' => 'group-add']);
    $routes->delete('groups/delete/(:any)', 'GroupsController::delete/$1', ['as' => 'group-delete']);

    // Permissions
    $routes->get('permissions', 'PermissionsController::index', ['as' => 'permissions-list']);
    $routes->get('permissions/add', 'PermissionsController::add', ['as' => 'permissions-add']);
    $routes->get('permissions/show/(:any)', 'PermissionsController::show/$1', ['as' => 'group-show']);
    $routes->post('permissions/save', 'PermissionsController::saveGroup', ['as' => 'group-save']);
    $routes->delete('permissions/delete/(:any)', 'PermissionsController::delete/$1', ['as' => 'group-delete']);

    // Tokens
    $routes->get('tokens/manage', 'TokensController::index', ['as' => 'tokens-manage']);
    $routes->match(['get', 'post'], 'tokens/create', 'TokensController::create', ['as' => 'tokens-create']);
});


// Clear cache
$routes->get('/clear-cache', static function() {
    command('Btwcache:clear');
    service('cache')->delete('twig');
    return "Cache is cleared";
}, ['filter' => 'session']);

// // Optimize
// Route::get('/optimize', function () {
//     Artisan::call('optimize');
//     return "Cache is optimized";
// })->middleware(['auth', 'admin']);

// $routes->get('/access/token', static function() {
//     $token = auth()->user()->generateAccessToken(service('request')->getVar('token_name'));
// //d42ecd648f7241a1fca9e6fe292feeaa35693715b77c96edd702251d1c53414f
//     return json_encode(['token' => $token->raw_token]);
// });