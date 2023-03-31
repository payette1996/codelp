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

    public static function postPost(User $user, Post $post) : bool {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":email", $user->getEmail());
        $stmt->execute();
        $id = $stmt->fetchColumn();
        $user->setId($id);

        $sql = "
            INSERT INTO posts (title, description, user_id, thread_id)
            VALUES (:title, :description, :user_id, :thread_id)
        ";
        $params = [
            ":title" => $post->getTitle(),
            ":description" => $post->getDescription(),
            ":user_id" => $user->getId(),
            ":thread_id" => $post->getThreadId()
        ];
        $stmt = Database::pdo()->prepare($sql);
        foreach ($params as $param => $value) $stmt->bindValue($param, $value);
        $result = $stmt->execute();
        return $result;
    }

    public static function putPost(User $user, Post $post, Post $new) : bool {
        $sql = "
            SELECT users.id, posts.user_id FROM users, posts
            WHERE users.email = :email AND posts.id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":email", $user->getEmail());
        $stmt->bindValue(":id", $post->getId());
        $stmt->execute();
        $row = $stmt->fetch();
        $user->setId($row["id"]);
        $post->setUserId($row["user_id"]);

        if ($post->getUserId() === $user->getId()) {
            $sql = "
                UPDATE posts
                SET title = :newTitle,
                description = :newDescription
                WHERE id = :id
            ";
            $stmt = Database::pdo()->prepare($sql);
            $params = [
                ":newTitle" => $new->getTitle(),
                ":newDescription" => $new->getDescription(),
                ":id" => $post->getId()
            ];
            foreach ($params as $param => $value) $stmt->bindValue($param, $value);
            return $stmt->execute();
        } else {
            return false;
        }
    }

    public static function deletePost(User $user, Post $post) : bool {
        $sql = "
            SELECT users.id, posts.user_id FROM users, posts
            WHERE users.email = :email AND posts.id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":email", $user->getEmail());
        $stmt->bindValue(":id", $post->getId());
        $stmt->execute();
        $row = $stmt->fetch();
        $user->setId($row["id"]);
        $post->setUserId($row["user_id"]);

        if ($post->getUserId() === $user->getId()) {
            $sql = "DELETE FROM Posts WHERE id = :id";
            $stmt = Database::pdo()->prepare($sql);
            $stmt->bindValue(":id", $post->getId());
            return $stmt->execute();
        } else {
            return false;
        }
    }
}
?>