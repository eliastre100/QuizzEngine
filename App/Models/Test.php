<?php

namespace App\Models;

use App\Repositories\QuestionsRepository;
use Core\MVC\Model;
use PDO;

class Test extends Model {
    protected $id;
    protected $title;
    protected $open = false;
    protected $duration;
    protected $retryMaxScore;
    protected $passScore;
    protected $penalty;
    protected $errors;

    public function applyUpdates(array $attributes) {
        parent::applyUpdates($attributes);
        $this->handleCheckboxChanges($attributes);
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function isOpen() {
        return $this->open != null && $this->open;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getRetryMaxScore() {
        return $this->retryMaxScore;
    }

    public function getPassScore() {
        return $this->passScore;
    }

    public function getPenalty() {
        return $this->penalty;
    }

    public function getQuestions() {
        if (!isset($this->questions)) {
            $this->questions = (new QuestionsRepository())->findAllByTestId($this->getId());
        }
        return $this->questions;
    }

    public function valid()
    {
        $this->errors = [];
        if (empty($this->title)) $this->errors['title'][] = 'The title must be defined';
        if (empty($this->duration) && $this->duration !== '0') $this->errors['duration'][] = 'The duration of the test must be defined';
        if (!is_numeric($this->duration) || $this->duration < 0) $this->errors['duration'][] = 'The duration must be a positive number';
        if (empty($this->retryMaxScore)) $this->errors['retryMaxScore'][] = 'The retry max score must be defined';
        if (!is_numeric($this->retryMaxScore) || $this->retryMaxScore < 0) $this->errors['retryMaxScore'][] = 'The score maximum to retake a test must be a positive number';
        if (empty($this->passScore)) $this->errors['passScore'][] = 'The score to pass the test must be defined';
        if (!is_numeric($this->passScore) || $this->passScore < 0) $this->errors['passScore'][] = 'The score to pass the test must be a positive number';
        if (empty($this->penalty)) $this->errors['penalty'][] = 'The penalty for a wrong answer must be defined';
        if (!is_numeric($this->penalty)) $this->errors['penalty'][] = 'The penalty must be a number';

        return count($this->errors) == 0;
    }

    public function save() {
        if ($this->getId())
            return $this->update();
        $statement = $this->getPdo()->prepare("INSERT INTO tests (title, open, duration, retryMaxScore, passScore, penalty) VALUES (:title, :open, :duration, :retryMaxScore, :passScore, :penalty)");
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':open', $this->isOpen(), PDO::PARAM_BOOL);
        $statement->bindParam(':duration', $this->duration);
        $statement->bindParam(':retryMaxScore', $this->retryMaxScore);
        $statement->bindParam(':passScore', $this->passScore);
        $statement->bindParam(':penalty', $this->penalty);
        $statement->execute();
        $this->id = $this->getPdo()->lastInsertId();
    }

    public function update() {
        if (!$this->getId())
            return $this->save();
        $statement = $this->getPdo()->prepare("UPDATE tests SET title = :title, open = :open, duration = :duration, retryMaxScore = :retryMaxScore, passScore = :passScore, penalty = :penalty WHERE id = :id");
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':open', $this->isOpen(), PDO::PARAM_BOOL);
        $statement->bindParam(':duration', $this->duration);
        $statement->bindParam(':retryMaxScore', $this->retryMaxScore);
        $statement->bindParam(':passScore', $this->passScore);
        $statement->bindParam(':penalty', $this->penalty);
        $statement->bindParam(':id', $this->getId());
        $statement->execute();
    }

    public function getErrors($key = null) {
        if ($key == null)
            return $this->errors;
        else if (isset($this->errors[$key]))
            return $this->errors[$key];
        else
            return [];
    }

    public function destroy()
    {
        $statement = $this->getPdo()->prepare("DELETE FROM tests WHERE tests.id = :id");
        $statement->bindParam(':id', $this->getId());
        $statement->execute();
    }

    private function handleCheckboxChanges(array $attributes)
    {
        if ($attributes != [])
            $this->open = isset($attributes['open']) && $attributes['open'] != 'off';
    }
}