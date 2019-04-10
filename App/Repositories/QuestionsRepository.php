<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Test;
use Core\MVC\Repository;

class QuestionsRepository extends Repository {
    public function findAll() {
        $statement = $this->getPdo()->prepare("SELECT * FROM questions");
        $statement->execute();
        return $statement->fetchAll( \PDO::FETCH_CLASS, Question::class);
    }

    public function findAllByTestId($id) {
        $statement = $this->getPdo()->prepare("SELECT * FROM questions WHERE test_id = :test_id");
        $statement->bindParam(':test_id', $id);
        $statement->execute();
        return $statement->fetchAll( \PDO::FETCH_CLASS, Question::class);
    }

    public function find($id)
    {
        $statement = $this->getPdo()->prepare("SELECT * FROM questions WHERE questions.id = :id LIMIT 1");
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetchObject(Question::class);
    }

    public function findAttemptRemaining($attempt) {
        $statement = $this->getPdo()->prepare("SELECT questions.* FROM questions
	        LEFT JOIN answers ON answers.question_id = questions.id AND answers.attempt_id = :attempt_id
        	WHERE questions.test_id = :test_id AND answers.id IS NULL");
        $statement->bindValue(':attempt_id', $attempt->getId());
        $statement->bindValue(':test_id', $attempt->getTest()->getId());
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, Question::class);
    }
}