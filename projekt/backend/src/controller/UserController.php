<?php
namespace App\Controller;


use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController
{

    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $loginData = json_decode($request->getBody(), true);
        $login = trim($loginData['login']);
        $password = trim($loginData['password']);

        if (empty($login) or empty($password)) {
            // user does not provided necessary attributes (login and password)
            return $response->withStatus(400, 'Bad input');
        } else if ($user = $this->repository->verifyLogin($login, $password)) {
            // after user is verified successfully, create the token and send it in response
            $token = $this->repository->createToken($user['id_users'], $user['login']);
            $responseData = [
                'token' => $token
            ];
            $json = json_encode($responseData);
            $response->getBody()->write($json);
            return $response->withStatus(201, 'OK');
        } else {
            // user provided bad username or password
            return $response->withStatus(401, 'Unauthorized');
        }
    }

    public function register(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = json_decode($request->getBody(), true);

        // TODO validate inputs before creating the user

        //overeni loginu a mailu od uzivatele - data:

        if(!preg_match("/^[a-zA-Z-1-9' ]*$/",$data['login'])){
            return $response->withStatus(403, 'Login must be created with only letters');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $response->withStatus(403, 'Wrong email format !');
        }

        //OVERENI JESTLI NENI EMAIL A LOGIN JIZ V DATABAZI:
        $emailOk = $this->repository->verifyUserEmail($data["email"]);
        $loginOk = $this->repository->verifyUserLogin($data["login"]);

        if ($emailOk["ver_email"] >= 1 or $loginOk["ver_login"] >= 1) {
            //echo $emailOk["ver_email"];
            //echo $loginOk["ver_login"];
            return $response->withStatus(403, 'Email or login is not unique');
        } else {
            $user = $this->repository->createUser($data);

            if ($user !== false) {
                unset($user['password']); // do not send password to frontend!
                $json = json_encode($user);
                $response->getBody()->write($json);
                return $response->withStatus(201, 'Created');
            } else {
                return $response->withStatus(409, 'Already exists');
            }
        }

    }



}