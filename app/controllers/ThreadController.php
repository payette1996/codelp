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
            SELECT threads.*, users.username, threads.user_id AS userId, threads.created_at AS createdAt
            FROM threads JOIN users ON threads.user_id = users.id
            WHERE threads.id = :id        
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? new Thread($result) : null;
    }

    public static function postThread(User $user, Thread $thread) : bool {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":email", $user->getEmail());
        $stmt->execute();
        $id = $stmt->fetchColumn();
        $user->setId($id);

        $sql = "
            INSERT INTO threads (title, description, user_id)
            VALUES (:title, :description, :user_id)
        ";
        $params = [
            ":title" => $thread->getTitle(),
            ":description" => $thread->getDescription(),
            ":user_id" => $user->getId(),
        ];
        $stmt = Database::pdo()->prepare($sql);
        foreach ($params as $param => $value) $stmt->bindValue($param, $value);
        $result = $stmt->execute();
        return $result;
    }

    public static function putThread(User $user, Thread $thread, Thread $new) : bool {
        $sql = "
            SELECT users.id, threads.user_id FROM users, threads
            WHERE users.email = :email AND threads.id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":email", $user->getEmail());
        $stmt->bindValue(":id", $thread->getId());
        $stmt->execute();
        $row = $stmt->fetch();
        $user->setId($row["id"]);
        $thread->setUserId($row["user_id"]);

        if ($thread->getUserId() === $user->getId()) {
            $sql = "
                UPDATE threads
                SET title = :newTitle,
                description = :newDescription
                WHERE id = :id
            ";
            $stmt = Database::pdo()->prepare($sql);
            $params = [
                ":newTitle" => $new->getTitle(),
                ":newDescription" => $new->getDescription(),
                ":id" => $thread->getId()
            ];
            foreach ($params as $param => $value) $stmt->bindValue($param, $value);
            return $stmt->execute();
        } else {
            return false;
        }
    }

    public static function deleteThread(User $user, Thread $thread) : bool {
        $sql = "
            SELECT users.id, threads.user_id FROM users, threads
            WHERE users.email = :email AND threads.id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":email", $user->getEmail());
        $stmt->bindValue(":id", $thread->getId());
        $stmt->execute();
        $row = $stmt->fetch();
        $user->setId($row["id"]);
        $thread->setUserId($row["user_id"]);

        if ($thread->getUserId() === $user->getId()) {
            $sql = "DELETE FROM threads WHERE id = :id";
            $stmt = Database::pdo()->prepare($sql);
            $stmt->bindValue(":id", $thread->getId());
            return $stmt->execute();
        } else {
            return false;
        }
    }
}
?>