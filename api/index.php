<?php
require "core/Helpers.php";
require "core/Database.php";
require "core/Router.php";
require base_path("models/user.php");

$router = new Core\Router;
$routes = require("routes.php");
$router->HandleRequest($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);


