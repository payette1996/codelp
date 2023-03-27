<?php
class ThreadController {
    public static function getThreadCount() : int {
        $sql = "SELECT COUNT(*) FROM threads";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }
}
?>