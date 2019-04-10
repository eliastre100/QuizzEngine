<?php

namespace App\Repositories;

use App\Models\Answer;
use Core\MVC\Repository;

class AnswersRepository extends Repository {
    public function findAllByAttemptAndQuestion($attempt_id, $question_id) {
        $statement = $this->getPdo()->prepare("SELECT * FROM answers WHERE answers.attempt_id = :attempt_id AND question_id = :question_id");
        $statement->bindParam(':attempt_id', $attempt_id);
        $statement->bindParam(':question_id', $question_id);
        $statement->execute();
        return $statement->fetchAll( \PDO::FETCH_CLASS, Answer::class);
    }

    public function findAllByAttempt($attemptId)
    {
        $statement = $this->getPdo()->prepare("SELECT * FROM answers WHERE answers.attempt_id = :attempt_id");
        $statement->bindParam(':attempt_id', $attemptId);
        $statement->execute();
        return $statement->fetchAll( \PDO::FETCH_CLASS, Answer::class);
    }
}