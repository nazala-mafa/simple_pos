<?php

namespace Config;

$routes = Services::routes();
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function(){
    return view('errors/html/error_404');
});
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

$routes->group('', [
    'namespace' => 'App\Controllers\Admin',
    'filter' => 'role:admin'
], function ($routes) {
    $routes->add('/admin', 'Dashboard::index');
});

$routes->group('', [
    'filter' => 'role:admin,owner'
], function($routes) {
    $routes->post('products/add_item_category', 'Products::add_item_category');
    $routes->resource('products/category', ['controller' => 'Owner\Categories', 'except' => 'show,edit,new']);
    $routes->presenter('products/supplies', ['controller' => 'Owner\Supplies']);
    $routes->presenter('products/suppliers', ['controller' => 'Owner\Suppliers']);
    $routes->presenter('products/orders', ['controller' => 'Owner\Orders']);
    $routes->presenter('products/customers', ['controller' => 'Owner\Customers']);
    $routes->presenter('products', ['controller' =>'Owner\Products', 'filter' => 'role:admin,owner']);
});


if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
