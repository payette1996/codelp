<?php
class PostController {
    public static function getPostCount() : int {
        $sql = "SELECT COUNT(*) FROM posts";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }
}
?>