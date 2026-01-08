<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// OPTIONS for preflight
$routes->options('(:any)', function () {
    return service('response')
        ->setHeader('Access-Control-Allow-Origin', 'http://localhost:5173')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->setStatusCode(200);
});
$routes->get('/', 'Home::index');

// $routes->group('api', function ($routes) {
    $routes->POST('api/login', 'Auth::login');

// hero data change route
$routes->group('api', function ($routes) {
    $routes->get('hero', 'Hero::index');
    $routes->post('admin/hero', 'Hero::saveHero');
});

// ye servises ka route hai 

$routes->group('api', function($routes){
    $routes->get('services', 'Services::index');
    $routes->post('admin/services', 'Services::create');
    $routes->delete('admin/services/(:num)', 'Services::delete/$1');
});

// ye why choose ka route hai 

// PUBLIC
$routes->get('api/about', 'About::index');

// ADMIN
$routes->group('api/admin', function ($routes) {
    $routes->post('about', 'About::saveAbout');
    $routes->post('about/point', 'About::addPoint');
    $routes->delete('about/point/(:num)', 'About::deletePoint/$1');
});

// ye route hai Testimonial ka liya hai 

// PUBLIC
$routes->get('api/testimonials', 'Testimonials::index');

// ADMIN
$routes->group('api/admin', function ($routes) {
    $routes->post('testimonials', 'Testimonials::save');
    $routes->delete('testimonials/(:num)', 'Testimonials::delete/$1');
});


// ye contact ka route hai 

$routes->get('api/contact', 'Contact::index');

// ADMIN CMS
$routes->post('api/admin/contact/content', 'Contact::saveContent');
$routes->post('api/admin/contact/item', 'Contact::saveItem');
$routes->delete('api/admin/contact/item/(:num)', 'Contact::deleteItem/$1');

// FORM SUBMIT (optional)
$routes->post('api/contact/submit', 'Contact::submit');