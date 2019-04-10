<?php

namespace App\Repositories;

use App\Models\Test;
use Core\MVC\Repository;

class TestRepository extends Repository {
    public function findAll() {
        $statement = $this->getPdo()->prepare("SELECT * FROM tests");
        $statement->execute();
        return $statement->fetchAll( \PDO::FETCH_CLASS, Test::class);
    }

    public function find($id)
    {
        $statement = $this->getPdo()->prepare("SELECT * FROM tests WHERE tests.id = :id LIMIT 1");
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetchObject(Test::class);
    }

    public function findNonAnsweredTestsByStatus($user_id, $open) {
        $statement = $this->getPdo()->prepare("SELECT DISTINCT tests.* FROM tests LEFT JOIN testAttempts ON tests.id = testAttempts.test_id AND testAttempts.user_id = :id WHERE (testAttempts.test_id IS NULL OR testAttempts.retry = true) AND tests.open = :open");
        $statement->bindParam(':id', $user_id);
        $statement->bindParam(':open', $open);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, Test::class);
    }
}