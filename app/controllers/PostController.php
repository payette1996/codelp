<?php
require_once "./app/models/Database.php";
require_once "./app/models/Post.php";

class PostController {
    public static function getCount() : int {
        $sql = "SELECT COUNT(*) FROM posts";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    public static function getPost(int $id) : ?Post {
        $sql = "
            SELECT id, title, description, user_id as userId, thread_id as threadId, created_at as createdAt
            FROM posts WHERE id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? new Post($result) : null;
    }

    public static function postPost(Post $post) : bool {
        $sql = "
            INSERT INTO posts (title, description, user_id, thread_id)
            VALUES (:title, :description, :user_id, :thread_id)
        ";
        $params = [
            ":title" => $post->getTitle(),
            ":description" => $post->getDescription(),
            ":user_id" => $post->getUserId(),
            ":thread_id" => $post->getThreadId()
        ];
        $stmt = Database::pdo()->prepare($sql);
        foreach ($params as $param => $value) $stmt->bindValue($param, $value);
        $result = $stmt->execute();
        return $result;
    }
}
?>