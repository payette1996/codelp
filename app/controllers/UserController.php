<?php
require_once "./app/models/Database.php";
require_once "./app/models/User.php";

class UserController {
    public static function getUserCount() : int {
        $sql = "SELECT COUNT(*) FROM users";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }
}
?>