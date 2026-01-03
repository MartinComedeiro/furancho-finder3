<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// API Routes
$routes->get('api/furanchos', 'API::getFuranchos');
$routes->get('api/furanchos/(:num)', 'API::getFurancho/$1');
$routes->get('api/users', 'API::getUsers');
$routes->get('api/users/(:num)', 'API::getUser/$1');
$routes->post('api/login', 'API::login');
