<?php

use core\ValidationException;

const BASE_PATH = __DIR__.'/../';

session_start();

require BASE_PATH.'core/function.php';

spl_autoload_register(function($class) {
    $result = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require base_path("$result.php");
});

require base_path('bootstrap.php');

$router = new core\Router();

$routes = require base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$method = $_POST['__method'] ?? $_SERVER['REQUEST_METHOD'];

try{
    $router->route($uri, $method);
}catch(ValidationException $validationException) {
    wrong($validationException->errors);
}