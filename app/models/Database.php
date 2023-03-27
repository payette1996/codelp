<?php
require_once "./config/database.php";

class Database {
    private static ?PDO $pdo = null;

    public static function pdo() : PDO {
        if (self::$pdo === null) {
            self::$pdo = new PDO(Config\DSN, Config\USERNAME, Config\PASSWORD, Config\OPTIONS);
        }
        return self::$pdo;
    }
}
?>