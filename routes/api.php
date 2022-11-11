<?php

use Common\Routing\Route;


$container = new DI\Container();
$route = $container->get('Common\Routing\Route');

$route->post('/v1/auth/register', \Api\Controllers\AuthController::class, 'register');
