<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// $routes->get('/data', 'GeneralRequestController::index');
$routes->get('/data', 'RequestController::getRequest');
