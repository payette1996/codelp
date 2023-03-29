<?php
require_once "./app/models/Database.php";
require_once "./app/models/Thread.php";

class ThreadController {
    public static function getCount() : int {
        $sql = "SELECT COUNT(*) FROM threads";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    public static function getThread(int $id) : ?Thread {
        $sql = "
            SELECT id, title, description, user_id as userId, created_at as createdAt
            FROM threads WHERE id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? new Thread($result) : null;
    }

    public static function postThread(Thread $thread) : bool {
        $sql = "
            INSERT INTO threads (title, description, user_id)
            VALUES (:title, :description, :user_id)
        ";
        $params = [
            ":title" => $thread->getTitle(),
            ":description" => $thread->getDescription(),
            ":user_id" => $thread->getUserId(),
        ];
        $stmt = Database::pdo()->prepare($sql);
        foreach ($params as $param => $value) $stmt->bindValue($param, $value);
        $result = $stmt->execute();
        return $result;
    }
}
?>