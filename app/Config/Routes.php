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
$routes->get('/account/create', 'Account::create');
$routes->post('/account/create', 'Account::addFirst');
$routes->get('/dashboard', 'Dashboard::index', ["filter" => "view:nocheck"]);
$routes->get('/collections', 'Collection::index', ["filter" => "view:collections"]);
$routes->get('/categories','Category::index', ["filter" => "view:categories"]);
$routes->get('/images','Image::index', ["filter" => "view:images"]);
$routes->get('/account', 'Account::index', ["filter" => "view:nocheck"]);
$routes->get('/notifications','Notification::index', ["filter" => "view:notifications"]);
$routes->get('/menu','Menu::index', ["filter" => "view:menu"]);
$routes->get('/brand','Brand::index', ["filter" => "view:brands"]);
$routes->get('/app','App::index', ["filter" => "view:builds"]);
$routes->get('/brand/branding/(:num)','Brand::branding/$1', ["filter" => "view:branding"]);
$routes->get('/brand/users/(:num)','Brand::users/$1', ["filter" => "view:admin"]);
$routes->get('/billing',"Account::billing", ["filter" => "view:nocheck"]); //TODO move this to account view
$routes->get('/reset/(:any)', 'Reset::index/$1');
$routes->get('/search', 'Navigation::search');


//Asset URLS
$routes->get('/assets/images/thumbnail/(:any)', 'Assets::imageThumbnail/$1');
$routes->get('/assets/images/(:any)', 'Assets::images/$1'); //TODO: add filters
$routes->get('/assets/collection/(:any)', 'Assets::colImages/$1');
$routes->get('/assets/category/(:any)', 'Assets::catImages/$1');
$routes->get('/assets/user/(:any)', 'Assets::user/$1');
$routes->get('/assets/menu/(:any)', 'Assets::menu/$1');
$routes->get('/assets/branding/(:num)/(:segment)', 'Assets::branding/$1/$2');

//Get URLs
$routes->post('/images','Image::post', ["filter" => "view:images"]);
$routes->post('/collections','Collection::post', ["filter" => "view:collections"]);
$routes->post('/categories','Category::post', ["filter" => "view:categories"]);
$routes->post('/notifications','Notification::post', ["filter" => "view:notifications"]);
$routes->post('/brand','Brand::setBrand', ["filter" => "view:nocheck"]);
$routes->post('/','LogIn::post');
$routes->get('/brand/users/user','Brand::userData', ["filter" => "view:admin"]);
$routes->post('/account','Account::post', ["filter" => "view:nocheck"]);
$routes->post('/reset','Reset::post');
$routes->post('/menu','Menu::post', ["filter" => "view:menu"]);

//remove urls
$routes->post('/images/delete', 'Image::delete', ["filter" => "remove:images"]);
$routes->post('/collections/delete', 'Collection::delete', ["filter" => "remove:collections"]);
$routes->post('/categories/delete', 'Category::delete', ["filter" => "remove:categories"]);
$routes->post('/notifications/delete', 'Notification::delete', ["filter" => "remove:notifications"]);
$routes->post('/menu/delete', 'Menu::delete', ["filter" => "remove:menu"]);
$routes->post('/brand/delete', 'Brand::removeBrand', ["filter" => "remove:branding,admin"]);
$routes->post('/brand/users/delete', 'Brand::removeUser', ["filter" => "remove:branding,admin"]);
$routes->post('/brand/users/unlink', 'Brand::unlinkUser', ["filter" => "remove:branding,admin"]);

//image upload
$routes->get("/images/upload","Image::uploadView", ["filter" => "add:images"]);
$routes->post("/images/upload","Image::upload/1", ["filter" => "add:images"]);
$routes->get("/images/upload/csv/(:segment)","Image::makeCSV/$1", ["filter" => "add:images"]);

//Update URLs
$routes->post('/reset/update', 'Reset::update');
$routes->post('/images/update', 'Image::update', ["filter" => "edit:images"]);
$routes->post('/collections/update','Collection::update', ["filter" => "edit:collections"]);
$routes->post('/categories/update','Category::update', ["filter" => "edit:categories"]);
$routes->post('/notifications/update','Notification::update', ["filter" => "edit:notifications"]);
$routes->post('/menu/update','Menu::update', ["filter" => "edit:menu"]);
$routes->post('/brand/users/update', 'Brand::updateUsers', ["filter" => "edit:brand,admin"]);
$routes->post('/brand/add', 'Brand::addBrand', ["filter" => "add:brand,admin"]);
$routes->post('/brand/branding/update', 'Brand::updateBrand', ["filter" => "edit:branding"]);
$routes->post('/stripe', "Account::updateBilling");
$routes->post('/brand/users/link', 'Brand::linkUser', ["filter" => "add:branding,admin"]);

//API routes
$routes->match(['get', 'post'], '/requests/v1/data', 'Request::data');

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
