<?php
session_start();

global $config; 
$config = require_once("../../config.php");

// autoloader for requiring classes on initialize or call
spl_autoload_register(function($class) {
  require "{$_SERVER['DOCUMENT_ROOT']}/{$GLOBALS['config']['baseFolder']}/{$class}.php";
});

$router = new \API\Core\Router;
$routes = require("../routes.php");
$router->HandleRequest($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"], $_REQUEST);


