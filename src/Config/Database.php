<?php

namespace App\Config;

use PDO;

class Database {
    public static function connect() {
        $db = new PDO('mysql:host=localhost;dbname=blogdb', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }

    public static function initializeDatabase() {
        $db = self::connect();
        $db->exec("CREATE DATABASE IF NOT EXISTS blogdb DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        $db->exec("USE blogdb;");
        echo "Database initialized successfully";
    }
}
