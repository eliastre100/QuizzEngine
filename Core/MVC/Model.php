<?php

namespace Core\MVC;

use PDO;

abstract class Model extends Database {
    public function __construct($attributes = [])
    {
        $this->applyUpdates($attributes);
    }

    public function applyUpdates(array $attributes) {
        foreach ($attributes as $key => $attr) {
            $key = str_replace('_', '', ucwords($key, '_'));
            $key[0] = strtolower($key[0]);
            $this->$key = $attr;
        }
    }

    protected function getPdo(): PDO {
        return Database::connection();
    }

    abstract public function valid();
    abstract public function save();
    abstract public function getErrors();
}