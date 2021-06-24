<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RoomController {

    private RoomRepository $repository;

    public function __construct(RoomRepository $repository) {
        $this->repository = $repository;
    }

    public function getAll(ResponseInterface $response): ResponseInterface {
        $rooms = $this->repository->getAll();
        $json = json_encode($rooms);
        $response->getBody()->write($json);
        return $response;
    }

    public function getById(ResponseInterface $response, int $id): ResponseInterface {
        $room = $this->repository->getById($id);

        if ($room !== false) {
            $json = json_encode($room);
            $response->getBody()->write($json);
            return $response;
        } else {
            return $response->withStatus(404, 'Not Found');
        }
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $room = json_decode($request->getBody(), true);
        $tokenPayload = $request->getAttribute('token');
        $userId = (int) $tokenPayload['userId'];

        if ($room !== null and !empty($room["title"]) and $userId) {
            $room = $this->repository->create($room, $userId);
            $json = json_encode($room);
            $response->getBody()->write($json);
            return $response->withStatus(201, 'Created');
        } else {
            return $response->withStatus(400, 'Bad input');
        }
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response, int $id): ResponseInterface
    {
        $room = $this->repository->getById($id);
        $updatedRoom = json_decode($request->getBody(), true);

        if (empty($updatedRoom["title"])) {
            return $response->withStatus(400, 'Bad input');
        } else if ($room !== false) {
            $updatedRoom = $this->repository->update($id, $updatedRoom);
            $json = json_encode($updatedRoom);
            $response->getBody()->write($json);
            return $response->withStatus(202, 'Updated');
        } else {
            return $response->withStatus(404, 'Not Found');
        }
    }

    public function delete(ResponseInterface $response, int $id): ResponseInterface
    {
        $this->repository->delete($id);
        return $response->withStatus(204);
    }

    public function getMessages(ResponseInterface $response, int $id): ResponseInterface
    {
        $messages = $this->repository->getAllMessages($id);
        $json = json_encode($messages);
        $response->getBody()->write($json);
        return $response;
    }


    public function sendMessages(ServerRequestInterface $request, ResponseInterface $response , int $id): ResponseInterface
    {
        $message = json_decode($request->getBody(), true);
        $room = $id;
        $tokenPayload = $request->getAttribute('token');
        $userId = (int) $tokenPayload['userId'];
        if($message['message'] != '') {
            if ($this->repository->sendMessage($room, $userId, (string)$message['message'])) {
                $mess = $this->repository->getAllMessages($room);
                $json = json_encode($mess);
                $response->getBody()->write($json);
                return $response->withStatus(202, 'Message was send');
            } else {
                return $response->withStatus(404, '404 - problem with send message to chat ');
            }
        }
        else
        {
            return $response->withStatus(409, 'Wrong input data');
        }
    }


    public function getUsers(ResponseInterface $response, int $id): ResponseInterface
    {
        $users = $this->repository->getUsers($id);
        $json = json_encode($users);
        $response->getBody()->write($json);
        return $response;
    }


    public function enterToRoom(ServerRequestInterface $request, ResponseInterface $response, int $id): ResponseInterface
    {

        $tokenPayload = $request->getAttribute('token');
        $userId = (int) $tokenPayload['userId'];

        $room = $id;

        if( $userId != null and $room != null)
        {
            if($this->repository->enterToRoom((int)$room, $userId)){
                $users = $this->repository->getUsers($room);
                $json = json_encode($users);
                $response->getBody()->write($json);
                return $response->withStatus(202, 'User enter to room');
            }
            else{
                $users = $this->repository->getUsers($room);
                $json = json_encode($users);
                $response->getBody()->write($json);
                return $response->withStatus(202, 'User is allready in this room');
            }
        }
        else
        {
            $response->getBody()->write('Something went wrong :/ ');
            return $response->withStatus(404, 'ERROR');
        }
    }











}