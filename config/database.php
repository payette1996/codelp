<?php
namespace Config;

use PDO;

const DRIVER = "mysql";
const HOST = "localhost";
const DATABASE = "codelp";
const USERNAME = "root";
const PASSWORD = "";
const CHARSET = "utf8mb4";
const OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

const DSN = DRIVER . ":host=" . HOST . ";dbname=" . DATABASE . ";charset=" . CHARSET;
?>