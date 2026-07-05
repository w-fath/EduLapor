<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

$routes->get('/', 'Home::index');
$routes->get('/tentang', 'Home::about');
$routes->get('/statistik', 'Home::statistik');
$routes->get('/statistik', 'PublicReportController::statistik');

$routes->get('/lacak-laporan', 'Home::lacak');
$routes->post('/lacak-laporan', 'Home::prosesLacak');

$routes->get('/laporan-publik', 'PublicReportController::index');
$routes->get('/laporan-publik/(:num)', 'PublicReportController::show/$1');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');

$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::storeRegister');

$routes->get('/logout', 'AuthController::logout');

/*
|--------------------------------------------------------------------------
| Pelapor / User Routes
|--------------------------------------------------------------------------
*/

$routes->get('/dashboard', 'DashboardController::index');

$routes->get('/laporan', 'ReportController::index');
$routes->get('/laporan/create', 'ReportController::create');
$routes->post('/laporan/store', 'ReportController::store');

$routes->get('/laporan/(:num)', 'ReportController::show/$1');
$routes->get('/laporan/(:num)/edit', 'ReportController::edit/$1');
$routes->post('/laporan/(:num)/update', 'ReportController::update/$1');
$routes->post('/laporan/(:num)/delete', 'ReportController::delete/$1');

$routes->post('/laporan/(:num)/vote', 'VoteController::toggle/$1');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('dashboard', 'AdminDashboardController::index');

    /*
    | Kelola Laporan
    */
    $routes->get('reports', 'AdminReportController::index');
    $routes->get('reports/(:num)', 'AdminReportController::show/$1');
    $routes->post('reports/(:num)/verify', 'AdminReportController::verify/$1');
    $routes->post('reports/(:num)/reject', 'AdminReportController::reject/$1');
    $routes->post('reports/(:num)/assign', 'AdminReportController::assign/$1');
    $routes->post('reports/(:num)/delete', 'AdminReportController::delete/$1');

    /*
    | Kelola Kategori
    */
    $routes->get('categories', 'AdminCategoryController::index');
    $routes->get('categories/create', 'AdminCategoryController::create');
    $routes->post('categories/store', 'AdminCategoryController::store');
    $routes->get('categories/(:num)/edit', 'AdminCategoryController::edit/$1');
    $routes->post('categories/(:num)/update', 'AdminCategoryController::update/$1');
    $routes->post('categories/(:num)/delete', 'AdminCategoryController::delete/$1');

    /*
    | Kelola Lokasi
    */
    $routes->get('locations', 'AdminLocationController::index');
    $routes->get('locations/create', 'AdminLocationController::create');
    $routes->post('locations/store', 'AdminLocationController::store');
    $routes->get('locations/(:num)/edit', 'AdminLocationController::edit/$1');
    $routes->post('locations/(:num)/update', 'AdminLocationController::update/$1');
    $routes->post('locations/(:num)/delete', 'AdminLocationController::delete/$1');

    /*
    | Kelola User
    */
    $routes->get('users', 'AdminUserController::index');
    $routes->get('users/create', 'AdminUserController::create');
    $routes->post('users/store', 'AdminUserController::store');
    $routes->get('users/(:num)/edit', 'AdminUserController::edit/$1');
    $routes->post('users/(:num)/update', 'AdminUserController::update/$1');
    $routes->post('users/(:num)/delete', 'AdminUserController::delete/$1');
});

/*
|--------------------------------------------------------------------------
| Petugas Routes
|--------------------------------------------------------------------------
*/

$routes->group('petugas', ['namespace' => 'App\Controllers\Petugas'], function ($routes) {
    $routes->get('dashboard', 'PetugasDashboardController::index');

    $routes->get('reports', 'PetugasReportController::index');
    $routes->get('reports/(:num)', 'PetugasReportController::show/$1');
    $routes->post('reports/(:num)/process', 'PetugasReportController::process/$1');
    $routes->post('reports/(:num)/complete', 'PetugasReportController::complete/$1');
    $routes->post('reports/(:num)/comment', 'PetugasReportController::comment/$1');
});