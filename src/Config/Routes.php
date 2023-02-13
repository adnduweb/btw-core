<?php
/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */


 // Authentication Routes that override Shield's
$routes->group('', ['namespace' => '\Btw\Core\Controllers'], static function ($routes) {
    $routes->get('register', 'RegisterController::registerView');
    $routes->post('register', 'RegisterController::registerAction');
    $routes->get('login', 'LoginController::loginView');
    $routes->post('login', 'LoginController::loginAction');
    $routes->get('login/magic-link', 'MagicLinkController::loginView', ['as' => 'magic-link']);
    $routes->post('login/magic-link', 'MagicLinkController::loginAction');
    $routes->get('login/verify-magic-link', 'MagicLinkController::verify', ['as' => 'verify-magic-link']);
});

service('auth')->routes($routes, ['except' => ['login', 'register']]);


// Btw Admin routes
$routes->group(ADMIN_AREA, ['namespace' => '\Btw\Core\Controllers\Admin'], static function ($routes) {
    $routes->get('/', 'DashboardController::index', ['as' => 'dashbord']);
    $routes->get('settings/general', 'GeneralSettingsController::general', ['as' => 'general-settings']);
    $routes->post('settings/general', 'GeneralSettingsController::saveGeneral');
    $routes->get('settings/timezones', 'GeneralSettingsController::getTimezones');
});
