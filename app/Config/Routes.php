<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('LogIn');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//Base URLs
$routes->get('/', 'LogIn::index');
$routes->get('/dashboard', 'Dashboard::index', ["filter" => "login:nocheck"]);
$routes->get('/collections', 'Collection::index', ["filter" => "login:collections"]);
$routes->get('/categories','Category::index', ["filter" => "login:categories"]);
$routes->get('/images','Image::index', ["filter" => "login:images"]);
$routes->get('/account', 'Account::index', ["filter" => "login:nocheck"]);
$routes->get('/notifications','Notification::index', ["filter" => "login:notifications"]);
$routes->get('/menu','Menu::index', ["filter" => "login:menu"]);
$routes->get('/brand','Brand::index', ["filter" => "login:brands"]);
$routes->get('/app','App::index', ["filter" => "login:builds"]);
$routes->get('/brand/branding/(:num)','Brand::branding/$1', ["filter" => "login:branding"]);
$routes->get('/brand/users/(:num)','Brand::users/$1', ["filter" => "login:admin"]);
$routes->get('/billing',"Account::billing", ["filter" => "login:nocheck"]);
$routes->get('/reset/(:any)', 'Reset::index/$1');

//Asset URLS
$routes->get('/assets/images/(:any)', 'Assets::images/$1');
$routes->get('/assets/collection/(:any)', 'Assets::colImages/$1');
$routes->get('/assets/category/(:any)', 'Assets::catImages/$1');
$routes->get('/assets/user/(:any)', 'Assets::user/$1');

//Data URLs
$routes->post('/images', 'Image::post');
$routes->post('/collections', 'Collection::post');
$routes->post('/categories', 'Category::post');
$routes->post('/notifications', 'Notification::post');
$routes->post('/brand', 'Brand::setBrand');
$routes->post('/', 'LogIn::post');
$routes->get('/brand/users/user', 'Brand::userData');
$routes->post('/account', 'Account::post');
$routes->post('/reset', 'Reset::post');

$routes->post('/reset/update', 'Reset::update');
$routes->post('/images/update', 'Image::update');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
