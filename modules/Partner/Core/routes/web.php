<?php
use Modules\Partner\Core\Http\Controllers\HomeController;
use Ivi\Http\JsonResponse;

/** @var \Ivi\Core\Router\Router $router */
$router->get('/partner', [HomeController::class, 'index']);
$router->get('/partner/ping', fn() => new JsonResponse([
    'ok' => true,
    'module' => 'Partner/Core'
]));