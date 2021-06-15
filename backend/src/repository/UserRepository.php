<?php

namespace App\Repository;

use DI\Container;
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


    public function verifyEmail(string $email): array | bool {
        $stmtVerifyEmail = $this->db->prepare("select count(*) as ver_email from users where email=:email");
        $stmtVerifyEmail->bindValue(':email', $email);
        $stmtVerifyEmail->execute();
        return $stmtVerifyEmail->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyLogin(string $login): array | bool{
        $stmtVerifyEmail = $this->db->prepare("select count(*) as ver_login from users where login=:login");
        $stmtVerifyEmail->bindValue(':login', $login);
        $stmtVerifyEmail->execute();
        return $stmtVerifyEmail->fetch(PDO::FETCH_ASSOC);
    }


    /*
    public function createUser(array $data): array | bool {
        $lastid = $this->db->lastInsertId();
        echo $lastid;

        $stmt = $this->db->prepare
        ("insert into users (id_users, login, email, password, name, surname, gender, registrated, role) 
        values (:id_users,:login,:email,:password, :name, :surname, :gender, :registrated, :role)");


        $stmt->bindValue(':id_users', $lastid);
        $stmt->bindValue(':login', $data['login']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':password', md5($data['password']));
        // to s tim nul je z APV ? nevim jestli to bude fungovat :D
        $stmt->bindValue(':name', empty($data['name'])?null:$data['name']);
        $stmt->bindValue(':surname', empty($data['surname'])?null:$data['surname']);
        $stmt->bindValue(':gender', empty($data['gender'])?null:$data['gender']);
        $stmt->bindValue(':registrated', time());
        $stmt->bindValue(':role', empty($data['role'])?null:$data['role']);
        $stmt->execute();

        $id = $this->db->lastInsertId();

        return $this->getUserById($id);
    }*/

    /*public function update(int $id, array $data): array
    {
        $stmt = $this->db->prepare("UPDATE rooms SET title=:title WHERE id_rooms=:id_rooms");
        $stmt->bindValue(':title', $data['title']);
        $stmt->bindValue(':id_rooms', $id);
        $stmt->execute();
        return $this->getById($id);
    }*/

    public function deleteUser(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id_users=:id_users");
        $stmt->bindValue(':id_users', $id);
        $stmt->execute();
    }
}