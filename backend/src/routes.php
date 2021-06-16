<?php

use App\Controller\HomeController;
use App\Controller\RoomController;
use App\Controller\UserController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {

    // Homepage
    $app->get('/', [HomeController::class, 'index']);

    // Rooms
    $app->get('/rooms', [RoomController::class, 'getAll']);
    $app->get('/rooms/{id}', [RoomController::class, 'getById']);
    $app->post('/rooms', [RoomController::class, 'create']);
    $app->put('/rooms/{id}', [RoomController::class, 'update']);
    $app->delete('/rooms/{id}', [RoomController::class, 'delete']);

    //Users
    $app->get('/users',[UserController::class,'getAllUsers']);
    $app->get('/users/{id}',[UserController::class,'getUserById']);
    $app->post('/registration',[UserController::class, 'register']);

    // CORS
    // - always respond successfully to options
    // - set up CORS headers - allow access from frontend on a different domain
    $app->options('/{routes:.+}', fn (ResponseInterface $response) => $response);
    $app->add(function (ServerRequestInterface $request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    // Not Found - handle all other routes as 404 Not Found error
    $app->map(['GET', 'POST', 'PUT', 'DELETE'], '/{routes:.+}', fn (ResponseInterface $response) =>
        $response->withStatus(404, 'Not Found')
    );

};