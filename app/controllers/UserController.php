<?php
require_once "./app/models/Database.php";
require_once "./app/models/User.php";

class UserController {
    public static function getCount() : int {
        $sql = "SELECT COUNT(*) FROM users";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    public static function getUser(int $id) : ?User {
        $sql = "
            SELECT id, email, username, firstname, lastname, password, created_at as createdAt
            FROM users WHERE id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? new User($result) : null;
    }

    public static function postUser(User $user) : bool {
        $sql = "
            INSERT INTO users (email, username, firstname, lastname, password)
            VALUES (:email, :username, :firstname, :lastname, :password)
        ";
        $params = [
            ":email" => $user->getEmail(),
            ":username" => $user->getUsername(),
            ":password" => $user->getPassword(),
            ":firstname" => $user->getFirstname(),
            ":lastname" => $user->getLastname(),
        ];
        $stmt = Database::pdo()->prepare($sql);
        foreach ($params as $param => $value) $stmt->bindValue($param, $value);
        return $stmt->execute();
    }

    public static function putUser(User $user) : bool {
        $sql = "
            UPDATE users
            SET email = :email,
            username = :username,
            firstname = :firstname,
            lastname = :lastname,
            password = :password
            WHERE id = :id
        ";
        $stmt = Database::pdo()->prepare($sql);
        $params = [
            ":email" => $user->getEmail(),
            ":username" => $user->getUsername(),
            ":firstname" => $user->getFirstname(),
            ":lastname" => $user->getLastname(),
            ":password" => $user->getPassword(),
            ":id" => $user->getId()
        ];
        foreach ($params as $param => $value) $stmt->bindValue($param, $value);
        return $stmt->execute();
    }

    public static function deleteUser(User $user) : bool {
        $sql = "DELETE FOM users WHERE id = :id";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(":id", $user->getId());
        return $stmt->execute();
    }
}
?>