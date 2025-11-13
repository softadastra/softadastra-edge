<?php
use Modules\Docs\Core\Http\Controllers\HomeController;
use Ivi\Http\JsonResponse;

/** @var \Ivi\Core\Router\Router $router */
$router->get('/docs', [HomeController::class, 'index']);
$router->get('/docs/ping', fn() => new JsonResponse([
    'ok' => true,
    'module' => 'Docs/Core'
]));