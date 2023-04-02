<?php
require_once "./app/models/Database.php";
require_once "./app/models/User.php";

class UserController {
    public static function auth(string $email, string $password) : ?User {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row && password_verify($password, $row["password"])) {
            return new User($row);
        } else {
            return null;
        }
    }

    public static function getAll() : array {
        $sql = "
            SELECT id, username, firstname, lastname, created_at AS createdAt
            FROM users ORDER BY id DESC
        ";
        $stmt = Database::pdo()->query($sql);
        $users = $stmt->fetchAll();
        return $users;
    }

    public static function getCount() : int {
        $sql = "SELECT COUNT(*) FROM users";
        $stmt = Database::pdo()->query($sql);
        $count = $stmt->fetchColumn();
        return $count;
    }

    public static function getUser(int $id) : array {
        $results = [];

        $sql = "
            SELECT id, email, username, firstname, lastname, created_at as createdAt
            FROM users WHERE id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $results["user"] = $stmt->fetch();

        $sql = "
            SELECT id, title, description, created_at AS createdAt FROM threads
            WHERE threads.user_id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $results["threads"] = $stmt->fetchAll();

        $sql = "
            SELECT id, title, description, thread_id AS threadId, created_at AS createdAt FROM posts
            WHERE posts.user_id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $results["posts"] = $stmt->fetchAll();

        return $results;
    }

    public static function postUser(User $user) : bool {
        $sql = "
            INSERT INTO users (email, username, password, firstname, lastname)
            VALUES (:email, :username, :password, :firstname, :lastname)
        ";
        $params = [
            ":email" => $user->getEmail(),
            ":username" => $user->getUsername(),
            ":password" => $user->getPassword(),
            ":firstname" => $user->getFirstname(),
            ":lastname" => $user->getLastname(),
            ":email" => $user->getEmail()
        ];
        $stmt = Database::pdo()->prepare($sql);
        foreach ($params as $param => $value) $stmt->bindValue($param, $value);
        return $stmt->execute();
    }

    public static function putUser(User $user, User $new) : bool {
        $sql = "
            UPDATE users
            SET email = :newEmail,
            username = :newUsername,
            password = :newPassword,
            firstname = :newFirstname,
            lastname = :newLastname
            WHERE email = :email
        ";
        $stmt = Database::pdo()->prepare($sql);
        $params = [
            ":newEmail" => $new->getEmail(),
            ":newUsername" => $new->getUsername(),
            ":newPassword" => $new->getPassword(),
            ":newFirstname" => $new->getFirstname(),
            ":newLastname" => $new->getLastname(),
            ":email" => $user->getEmail()
        ];
        foreach ($params as $param => $value) $stmt->bindValue($param, $value);
        return $stmt->execute();
    }

    public static function deleteUser(User $user) : bool {
        $sql = "DELETE FROM users WHERE email = :email";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":email", $user->getEmail());
        return $stmt->execute();
    }
}
?>