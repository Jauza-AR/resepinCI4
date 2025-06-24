<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('me', 'Pengguna::me');

$routes->get('resep/detail/(:num)', 'Resep::detail/$1');
$routes->get('resep/populer', 'Resep::populer');
$routes->post('pengguna/login', 'Pengguna::login');
$routes->resource('resep');
$routes->resource('pengguna');
$routes->resource('resepfavorit');
$routes->resource('komentar');
$routes->post('reseplike/like', 'ResepLike::likeResep');
$routes->post('favorite/add', 'ResepFavorit::addToFavorites');
$routes->post('favorite/remove', 'ResepFavorit::removeFromFavorites');
$routes->get('favorite/user/(:num)', 'ResepFavorit::getFavoritesByUser/$1');
$routes->get('komentar/resep/(:num)', 'Komentar::byResep/$1');