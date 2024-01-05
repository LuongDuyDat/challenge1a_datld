<?php

require base_path('core/router.php');

$router = new Router();

$router->get('/', base_path('controller/index_controller.php'));
$router->get('/login', base_path('controller/login_controller.php'));
$router->get('/home', base_path('controller/home_controller.php'));
$router->post('/login', base_path('controller/login_controller.php'));
$router->post('/home', base_path('controller/home_controller.php'));

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);