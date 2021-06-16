<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ChatController {

    private ChatRepository $repository;

    public function __construct(RoomRepository $service) {
        $this->repository = $service;
    }


    public function getMessagesByIdRoom(ResponseInterface $response, int $idRoom): ResponseInterface {

        $messages = $this->repository->getMessagesByIdRoom($idRoom);

        if ($messages !== false) {
            $json = json_encode($messages);
            $response->getBody()->write($json);
            return $response;
        } else {
            return $response->withStatus(404, 'Room Not Found');
        }
    }

    public function newMessage(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $message = json_decode($request->getBody(), true);

        if ($message !== null and isset($message["text"]) and isset($message["id_room"])) {
            $message = $this->repository->newMessage($message);
            $json = json_encode($message);
            $response->getBody()->write($json);
            return $response->withStatus(201, 'Message was send');
        } else {
            return $response->withStatus(400, 'Bad input');
        }
    }

   

}