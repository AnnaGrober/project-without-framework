<?php

use Common\Routing\Route;
use DevCoder\DotEnv;

(new DotEnv(__DIR__ . '/../.env'))->load();

$container = new Common\Containers\DIContainer();
$container->init();
$route = $container->get('Common\Routing\Route');

$route->post('/v1/auth/register', \Api\Controllers\AuthController::class, 'register');
