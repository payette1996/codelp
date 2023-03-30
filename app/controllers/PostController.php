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
            SELECT posts.*, users.username, threads.title AS threadTitle, posts.user_id AS userId, posts.thread_id AS threadId, posts.created_at AS createdAt
            FROM posts
            JOIN users ON posts.user_id = users.id
            JOIN threads ON posts.thread_id = threads.id
            WHERE posts.id = :id
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

    public static function putPost(Post $post) : bool {
        $sql = "
            UPDATE posts
            SET title = :title,
            description = :description,
            WHERE id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $params = [
            ":title" => $post->getTitle(),
            ":description" => $post->getDescription(),
            ":id" => $post->getId()
        ];
        foreach ($params as $param => $value) $stmt->bindValue($param, $value);
        return $stmt->execute();
    }

    public static function deletePost(Post $post) : bool {
        $sql = "DELETE FOM Posts WHERE id = :id";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":id", $post->getId());
        return $stmt->execute();
    }
}
?>