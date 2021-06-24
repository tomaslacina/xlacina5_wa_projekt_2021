<?php

namespace App\Repository;

use DI\Container;
use PDO;

class RoomRepository {

    private PDO $db;

    public function __construct(Container $container)
    {
        $this->db = $container->get('db');
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("select * from rooms");
        $stmt->execute();
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rooms;
    }

    public function getById(int $id): array | bool
    {
        $stmt = $this->db->prepare("select * from rooms where id_rooms=:id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data, int $userId): array {
        $stmt = $this->db->prepare("insert into rooms (title, created, id_users_owner) values (:title,:created,:id_users_owner)");
        $stmt->bindValue(':title', $data['title']);
        $stmt->bindValue(':created', time());
        $stmt->bindValue(':id_users_owner', $userId);
        $stmt->execute();

        $id = $this->db->lastInsertId();

        return $this->getById($id);
    }

    public function update(int $id, array $data): array
    {
        $stmt = $this->db->prepare("UPDATE rooms SET title=:title WHERE id_rooms=:id_rooms");
        $stmt->bindValue(':title', $data['title']);
        $stmt->bindValue(':id_rooms', $id);
        $stmt->execute();
        return $this->getById($id);
    }

    public function delete (int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM rooms WHERE id_rooms=:id_rooms");
        $stmt->bindValue(':id_rooms', $id);
        $stmt->execute();
    }


    public function getAllMessages(int $idRoom): array
    {
        $stmt = $this->db->prepare("SELECT  (name || ' ' || surname) as name, message, created FROM messages 
            join users  on users.id_users = messages.id_users_from 
            WHERE id_rooms=:id_rooms");
        $stmt->bindValue(':id_rooms', $idRoom);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $messages;
    }


    public function sendMessage(int $roomId, int $userId, string $message): bool {

        $stmt = $this->db->prepare("insert into messages (id_rooms, id_users_from, created, message)
            values (:roomId, :userId, :created, :message)");
        $stmt->bindValue(':message', $message);
        $stmt->bindValue(':created', time());
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':roomId', $roomId);
        $stmt->execute();
        return true;

    }


    public function enterToRoom(int $roomId, int $userId): bool {
        if(!$this->getData($roomId,$userId)){
            return false;
        }
        else {
            $stmt = $this->db->prepare("insert into in_room (id_users, id_rooms, last_message, entered) 
            values (:userId, :roomId, :lastMessage, :entered)");

            $stmt->bindValue(':userId', $userId);
            $stmt->bindValue(':roomId', $roomId);
            $stmt->bindValue(':lastMessage', time());
            $stmt->bindValue(':entered', time());

            $stmt->execute();
            return true;
        }
    }


    public function getData(int $roomId, int $userId): bool
    {
        $stmt = $this->db->prepare("SELECT * FROM in_room 
                        WHERE id_users = :id_users 
                        AND id_rooms = :id_rooms");
        $stmt->bindValue(':id_users', $userId);
        $stmt->bindValue(':id_rooms', $roomId);
        $stmt->execute();
        $rooms = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rooms!=null){
            return false;
        }else{
            return true;
        }
    }

    public function getUsers(int $idRoom): array
    {
        $stmt = $this->db->prepare("SELECT u.id_users, u.name || ' ' || u.surname as name FROM in_room
        join users u on u.id_users = in_room.id_users
        where id_rooms=:id_rooms");
        $stmt->bindValue(':id_rooms', $idRoom);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }



    public function isOwner(int $roomId, int $userId) : bool
    {
        $stmt = $this->db->prepare("SELECT * FROM rooms WHERE id_rooms=:roomId AND id_users_owner=:userId");
        $stmt->bindValue(':roomId', $roomId);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        $owner = $stmt->fetch(PDO::FETCH_ASSOC);
        if($owner!=null){
            return true;
        }
        else{
            return false;
        }

    }

    public function leaveRoom(int $roomId, int $userId) : bool
    {
        $stmt = $this->db->prepare("DELETE FROM in_room WHERE id_users=:userId AND id_rooms=:roomId");
        $stmt->bindValue(':roomId', $roomId);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        return true;
    }






}