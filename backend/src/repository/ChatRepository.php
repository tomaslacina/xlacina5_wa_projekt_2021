<?php

namespace App\Repository;

use DI\Container;
use PDO;

class ChatRepository {

    private PDO $db;

    public function __construct(Container $container)
    {
        $this->db = $container->get('db');
    }


    public function getMessagesByIdRoom(int $idRoom): array | bool
    {
        $stmt = $this->db->prepare("select * from messages where id_rooms=:idRoom");
        $stmt->bindValue(':id', $idRoom);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function newMessage(array $data, int $userId = 0, int $id_room): array {
        $stmt = $this->db->prepare("insert into messages (id_rooms, id_users_from, created,message) 
values (:id_room,:userId,:created,:message)");
        $stmt->bindValue(':id_room', $id_room);
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':created', time());
        $stmt->bindValue(':message',$data['message']);
        $stmt->execute();

        $id = $this->db->lastInsertId();

        return $this->getMessagesByIdRoom($id_room);
    }

}