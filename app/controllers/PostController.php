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
}
?>