<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/',              'AuthController::loginPage');
$routes->get('login',           'AuthController::loginPage');
$routes->post('login',          'AuthController::login');

$routes->group('rh', ['namespace' => 'App\Controllers\RH'], function ($routes) {
    $routes->get('demandes', 'RhController::demandes');
    $routes->get('approuver/(:num)', 'RhController::approuver/$1');
    $routes->post('refuser/(:num)', 'RhController::refuser/$1');
    $routes->get('soldes', 'RhController::soldes');
    $routes->get('historique', 'RhController::historique'); 
});


$routes->group('employe', ['namespace' => 'App\Controllers\Employe'], function ($routes) {
    $routes->get('/',              'DashboardController::index');  // ← ajouter
    $routes->get('conges',         'CongeController::index');
    $routes->get('conges/demande', 'CongeController::demandeForm');
    $routes->post('conges/demande','CongeController::demande');
});