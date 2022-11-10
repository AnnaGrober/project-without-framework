<?php

use Common\Routing\Route;

$route = new Route();

$route->post('/v1/auth/register', \Api\Controllers\AuthController::class, 'register');

