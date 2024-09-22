<?php

//test
$router->get('/','index.php')->only('delegate');
//customer
$router->post('/customer', 'customer/store.php')->only('delegate');
$router->get('/customer', 'customer/index.php')->only('delegate');
$router->patch('/customer', 'customer/update.php')->only('admin');
$router->delete('/customer', 'customer/destroy.php')->only('admin');
//dealer
$router->post('/dealer', 'dealer/store.php')->only('admin');
$router->get('/dealer', 'dealer/index.php')->only('delegate');
$router->patch('/dealer', 'dealer/update.php')->only('admin');
$router->delete('/dealer', 'dealer/destroy.php')->only('admin');
//delegate
$router->post('/delegate', 'delegate/store.php')->only('admin');
$router->get('/delegate', 'delegate/index.php')->only('delegate');
$router->patch('/delegate', 'delegate/update.php')->only('admin');
$router->delete('/delegate', 'delegate/destroy.php')->only('admin');
//product
$router->post('/product', 'products/store.php')->only('delegate');
$router->get('/product', 'products/index.php')->only('delegate');
$router->patch('/product', 'products/update.php')->only('admin');
$router->delete('/product', 'products/destroy.php')->only('admin');
//unit
$router->post('/unit', 'units/store.php')->only('admin');
$router->get('/unit', 'units/index.php')->only('delegate');
$router->patch('/unit', 'units/update.php')->only('admin');
$router->delete('/unit', 'units/destroy.php')->only('admin');
//invoice
$router->post('/invoice', 'invoices/store.php')->only('delegate');
$router->get('/invoice', 'invoices/index.php')->only('delegate');
$router->patch('/invoice', 'invoices/update.php')->only('admin');
$router->delete('/invoice', 'invoices/destroy.php')->only('admin');