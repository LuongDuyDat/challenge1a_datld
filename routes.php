<?php

require 'core/router.php';

$router = new Router();

$router->get('/', 'controller/login_controller.php');
$router->post('/', 'controller/login_controller.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);