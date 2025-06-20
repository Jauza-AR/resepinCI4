<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('resep/(:num)', 'Resep::detail/$1');
$routes->resource('resep');
$routes->resource('pengguna');
$routes->post('reseplike/like', 'ResepLike::likeResep');
