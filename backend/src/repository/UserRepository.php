<?php

namespace App\Repository;

use DI\Container;
use Firebase\JWT\JWT;
use PDO;

class UserRepository {

    private PDO $db;

    public function __construct(Container $container)
    {
        $this->db = $container->get('db');
    }

    public function getAllUsers(): array
    {
        $stmt = $this->db->prepare("select * from users");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function getUserById(int $id): array | bool
    {
        $stmt = $this->db->prepare("select * from users where id_users=:id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function verifyUserEmail(string $email): array | bool {
        $stmtVerifyEmail = $this->db->prepare("select count(*) as ver_email from users where email=:email");
        $stmtVerifyEmail->bindValue(':email', $email);
        $stmtVerifyEmail->execute();
        return $stmtVerifyEmail->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyUserLogin(string $login): array | bool{
        $stmtVerifyEmail = $this->db->prepare("select count(*) as ver_login from users where login=:login");
        $stmtVerifyEmail->bindValue(':login', $login);
        $stmtVerifyEmail->execute();
        return $stmtVerifyEmail->fetch(PDO::FETCH_ASSOC);
    }


    public function createUser(array $data): array | bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO users
                (login, email, password, name, surname, gender, registered, role)
            VALUES 
                (:login, :email, :password, :name, :surname, :gender, :registered, :role)
        ");

        $stmt->bindValue(':login', $data['login']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':surname', $data['surname']);
        $stmt->bindValue(':gender', $data['gender']);
        $stmt->bindValue(':registered', time());
        $stmt->bindValue(':role', $data['role']);

        try {
            $stmt->execute();
            $id = $this->db->lastInsertId();
            return $this->getById($id);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function deleteUser(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id_users=:id_users");
        $stmt->bindValue(':id_users', $id);
        $stmt->execute();
    }

    public function verifyLogin(string $login, string $password): array | bool
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE login=:login");
        $stmt->bindValue(':login', $login);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user !== false) {
            $hash = $user["password"];
            if (password_verify($password, $hash)) {
                return $user;
            }
        }

        return false;
    }

    public function createToken(int $userId): string
    {
        $tokenKey = $_ENV['TOKEN_KEY'];
        $tokenPayload = [
            "userId" => $userId,
        ];
        return JWT::encode($tokenPayload, $tokenKey, "HS256");
    }


}