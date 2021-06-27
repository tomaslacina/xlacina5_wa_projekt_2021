<?php

use App\Controller\HomeController;
use App\Controller\RoomController;
use App\Controller\UserController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

    // Homepage
    $app->get('/', [HomeController::class, 'index']);

    // Login and registration
    $app->post('/login', [UserController::class, 'login']);
    $app->post('/register', [UserController::class, 'register']);



    // --- Secured routes ---
    $app->group('/auth', function(RouteCollectorProxy $group) {

        // All Rooms
        $group->get('/rooms', [RoomController::class, 'getAll']);
        //Get 1 room by Id
        $group->get('/rooms/{id}', [RoomController::class, 'getById']);
        //Get all messages in room
        $group->get('/rooms/getMessages/{id}',[RoomController::class, 'getMessages']);
        //Get all users in room
        $group->get('/rooms/getUsers/{id}',[RoomController::class, 'getUsers']);
        //Send message in room
        $group->post('/rooms/sendMessage/{id}', [RoomController::class, 'sendMessage']);
        //Enter to this room
        $group->post('/rooms/enterRooms/{id}', [RoomController::class, 'enterToRoom']);
        //get information about if user is owner or not
        $group->post('/rooms/isUserOwner/{id}', [RoomController::class, 'isOwner']);
        //leave this room (delete logged-in user from this room)
        $group->delete('/rooms/leaveRoom/{id}', [RoomController::class, 'leaveRoom']);

        //Create new room
        $group->post('/rooms', [RoomController::class, 'create']);
        //update - ze cvika
        $group->put('/rooms/{id}', [RoomController::class, 'update']);
        //delete this room (if user is owner)
        $group->delete('/rooms/{id}', [RoomController::class, 'delete']);


    });
    // --- end of Secured routes ---

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