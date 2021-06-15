<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController {

    private UserRepository $repository;

    public function __construct(UserRepository $service) {
        $this->repository = $service;
    }

    public function getAllUsers(ResponseInterface $response): ResponseInterface {
        $users = $this->repository->getAllUsers();
        $json = json_encode($users);
        $response->getBody()->write($json);
        return $response;
    }

    public function getUserById(ResponseInterface $response, int $id): ResponseInterface {
        $user = $this->repository->getUserById($id);

        if ($user !== false) {
            $json = json_encode($user);
            $response->getBody()->write($json);
            return $response;
        } else {
            return $response->withStatus(404, 'User with this id not Found');
        }
    }



    public function createUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $user = json_decode($request->getBody(), true);

        if ($user !== null and isset($user["login"]) and $user["email"] and $user["password"]) {

            $emailOk = $this->repository->verifyEmail($user["email"]);
            $loginOk = $this->repository->verifyLogin($user["login"]);

            if($emailOk["ver_email"] >= 1 or $loginOk["ver_login"] >= 1){
                //echo $emailOk["ver_email"];
                //echo $loginOk["ver_login"];
                return $response->withStatus(400, 'Email or login is not unique');
            }
            else{
                $user = $this->repository->createUser($user);
                $json = json_encode($user);
                $response->getBody()->write($json);
                return $response->withStatus(201, 'User was created');
            }

        } else {
            return $response->withStatus(400, 'Bad input data');
        }
    }

    public function updateUser(ServerRequestInterface $request, ResponseInterface $response, int $id): ResponseInterface
    {
        $user = $this->repository->getUserById($id);
        $updatedUser = json_decode($request->getBody(), true);

        if (empty($updatedUser["login"])) {
            return $response->withStatus(400, 'Bad input');
        } else if ($user !== false) {
            $updatedUser = $this->repository->updateUser($id, $updatedUser);
            $json = json_encode($updatedUser);
            $response->getBody()->write($json);
            return $response->withStatus(202, 'User was updated');
        } else {
            return $response->withStatus(404, 'User not found');
        }
    }

    public function deleteUser(ResponseInterface $response, int $id): ResponseInterface
    {
        $this->repository->deleteUser($id);
        return $response->withStatus(204, 'User was successfull deleted from database');
    }

}