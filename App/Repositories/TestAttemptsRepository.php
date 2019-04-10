<?php

namespace App\Repositories;

use App\Models\TestAttempt;
use Core\MVC\Repository;

class TestAttemptsRepository extends Repository {
    public function findByTestAndUser($testId, $userId)
    {
        $statement = $this->getPdo()->prepare("SELECT * FROM testAttempts WHERE user_id = :user_id AND test_id = :test_id");
        $statement->bindParam(':test_id', $testId);
        $statement->bindParam(':user_id', $userId);
        $statement->execute();
        return $statement->fetchAll( \PDO::FETCH_CLASS, TestAttempt::class);
    }

    public function find($id)
    {
        $statement = $this->getPdo()->prepare("SELECT * FROM testAttempts WHERE testAttempts.id = :id LIMIT 1");
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetchObject(TestAttempt::class);
    }

    public function findAllByUser($user_id) {
        $statement = $this->getPdo()->prepare("SELECT * FROM testAttempts WHERE testAttempts.user_id = :id");
        $statement->bindParam(':id', $user_id);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, TestAttempt::class);
    }

    public function blockRetake($user_id, $test_id) {
        $statement = $this->getPdo()->prepare("UPDATE testAttempts SET retry = false WHERE testAttempts.user_id = :user_id AND testAttempts.test_id = :test_id");
        $statement->bindParam(':user_id', $user_id);
        $statement->bindParam(':test_id', $test_id);
        $statement->execute();
    }

    public function findAllByTest($test_id)
    {
        $statement = $this->getPdo()->prepare("SELECT * FROM testAttempts WHERE testAttempts.test_id = :test_id ORDER BY testAttempts.user_id, testAttempts.score DESC");
        $statement->bindParam(':test_id', $test_id);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, TestAttempt::class);
    }
}