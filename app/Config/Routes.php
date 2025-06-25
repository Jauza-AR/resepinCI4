<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('me', 'Pengguna::me');


$routes->put('pengguna/update/(:num)', 'Pengguna::update/$1');

$routes->get('resep/detail/(:num)', 'Resep::detail/$1');
$routes->get('resep/populer', 'Resep::populer');
$routes->get('resep/kategori/(:segment)', 'Resep::byKategori/$1');
$routes->get('resep/semua-by-user/(:num)', 'Resep::semuaByUser/$1');
$routes->get('favorite/user/(:num)', 'ResepFavorit::getFavoritesByUser/$1');
$routes->get('komentar/resep/(:num)', 'Komentar::byResep/$1');


$routes->post('pengguna/login', 'Pengguna::login');

$routes->resource('resep');

//pengguna favorit
$routes->group('penggunafavorit', function($routes) {
    $routes->get('(:num)', 'PenggunaFavorit::index/$1');
    $routes->post('/', 'PenggunaFavorit::create');
    $routes->delete('(:num)/(:num)', 'PenggunaFavorit::delete/$1/$2');
});

$routes->resource('pengguna');

$routes->resource('resepfavorit');

$routes->get('komentar/resep/(:num)', 'Komentar::byResep/$1');
$routes->resource('komentar');

$routes->post('upload-foto', 'UploadController::uploadFoto');
$routes->post('reseplike/like', 'ResepLike::likeResep');
$routes->post('favorite/add', 'ResepFavorit::addToFavorites');
$routes->post('favorite/remove', 'ResepFavorit::removeFromFavorites');


$routes->delete('favorite/remove', 'ResepFavorit::removeFromFavorites');

