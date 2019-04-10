<?php

namespace Core\MVC;


use PDO;

class Database {
    static private $connection;

    static public function connect($options) {
        try {
            self::$connection = new PDO('mysql:host='.$options['host'].';dbname='.$options['database'].';port='.$options['port'], $options['username'], $options['password']);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Exception("Unable to connect to the database", 500);
        }
    }

    static public function connection() {
        return self::$connection;
    }
}