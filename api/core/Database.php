<?php

class Database
{
    private static $pdo = null;

    public static function getConnection()
    {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../config/config.php';
            $db = $config['db'];

            $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset={$db['charset']}";

            try {
                self::$pdo = new PDO($dsn, $db['user'], $db['pass']);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // In production, log the error to a file
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
