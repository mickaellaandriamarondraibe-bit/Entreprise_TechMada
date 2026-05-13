<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/',              'AuthController::loginPage');
$routes->get('login',           'AuthController::loginPage');
$routes->post('login',          'AuthController::login');

