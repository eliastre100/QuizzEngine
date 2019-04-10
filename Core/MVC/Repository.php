<?php

namespace Core\MVC;

use PDO;

class Repository {
    protected function getPdo(): PDO {
        return Database::connection();
    }
}