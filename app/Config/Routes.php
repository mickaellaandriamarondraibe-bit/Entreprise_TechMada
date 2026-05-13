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
    $routes->get('dashboard', 'RhController::dashboard');
});


$routes->group('employe', ['namespace' => 'App\Controllers\Employe'], function ($routes) {
    $routes->get('/',              'DashboardController::index');  // ← ajouter
    $routes->get('conges',         'CongeController::index');
<<<<<<< HEAD
   $routes->get('conges/create',         'CongeController::create');
    $routes->post('conges/store',         'CongeController::store');
    $routes->get('conges/cancel/(:num)',  'CongeController::cancel/$1');
=======
    $routes->get('conges/demande', 'CongeController::demandeForm');
    $routes->post('conges/demande','CongeController::demande');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('', 'AdminController::dashboard');
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('employes', 'AdminController::employes');
    $routes->get('employes/create', 'AdminController::createEmploye');
    $routes->post('employes/store', 'AdminController::storeEmploye');
    $routes->get('employes/edit/(:num)', 'AdminController::editEmploye/$1');
    $routes->post('employes/update/(:num)', 'AdminController::updateEmploye/$1');
    $routes->get('employes/delete/(:num)', 'AdminController::deleteEmploye/$1');
>>>>>>> ac1edf7682d4ce906632f652af5a0aa048eb6707
});