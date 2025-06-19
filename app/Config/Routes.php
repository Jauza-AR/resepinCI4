<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->resource('resep');
$routes->resource('pengguna');
$routes->post('reseplike/like', 'ResepLike::likeResep');
$routes->get('komentar/resep/(:num)', 'Komentar::byResep/$1');
$routes->resource('komentar');