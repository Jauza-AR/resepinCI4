<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->resource('resep');
$routes->resource('Pengguna');
// $routes->resource('penggunafavorit');
$routes->group('penggunafavorit', function($routes) {
    $routes->get('(:num)', 'PenggunaFavorit::index/$1');
    $routes->post('/', 'PenggunaFavorit::create');
    $routes->delete('(:num)/(:num)', 'PenggunaFavorit::delete/$1/$2');
});

