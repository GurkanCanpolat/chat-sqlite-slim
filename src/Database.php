<?php

namespace App;

use PDO;

class Database {
    private static ?PDO $instance = null;

    public static function get(): PDO {
        if (self::$instance === null) {
            self::$instance = new PDO('sqlite:' . __DIR__ . '/../database/chat.db');
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}
