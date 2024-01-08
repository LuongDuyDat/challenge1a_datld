<?php

require base_path('core/router.php');

$router = new Router();

$router->get('/', base_path('controller/index_controller.php'));
$router->get('/login', base_path('controller/login_controller.php'));
$router->get('/home', base_path('controller/home_controller.php'));
$router->get('/search', base_path('controller/search_controller.php'));
$router->get('/logout', base_path('controller/logout_controller.php'));
$router->get('/profile', base_path('controller/profile_controller.php'));
$router->get('/student/add', base_path('controller/add_student_controller.php'));
$router->get('/exercise', base_path('controller/exercise_controller.php'));
$router->get('/exercise/$', base_path('controller/homework_controller.php'));
$router->post('/login', base_path('controller/login_controller.php'));
$router->post('/home', base_path('controller/home_controller.php'));
$router->post('/search', base_path('controller/search_controller.php'));
$router->post('/profile', base_path('controller/profile_controller.php'));
$router->post('/student/add', base_path('controller/add_student_controller.php'));
$router->post('/exercise', base_path('controller/exercise_controller.php'));
$router->post('/exercise/$', base_path('controller/homework_controller.php'));

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);