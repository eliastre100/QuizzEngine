<?php

namespace App\Models;

use App\Repositories\AnswersRepository;
use App\Repositories\TestRepository;
use App\Repositories\UserRepository;
use Core\MVC\Model;

class TestAttempt extends Model {
    protected $id;
    protected $userId;
    protected $user;
    protected $testId;
    protected $test;
    protected $score = 0;
    protected $pass = false;
    protected $retry = true;
    protected $createdAt;
    protected $updatedAt;
    protected $answers = [];
    private $errors;

    public function applyUpdates(array $attributes) {
        parent::applyUpdates($attributes);
        $this->applyCaseFormat();
    }

    public function getId() {
        return $this->id;
    }

    public function getUser() {
        if (!isset($this->user) || $this->user == null)
            $this->user = (new UserRepository())->find($this->userId);
        return $this->user;
    }

    public function getTest() {
        if (!isset($this->test) || $this->test == null)
            $this->test = (new TestRepository())->find($this->testId);
        return $this->test;
    }

    public function getScore() {
        return $this->score;
    }

    public function isPass() {
        return $this->pass;
    }

    public function canRetry() {
        return $this->retry;
    }

    public function setRetry($retry) {
        $this->retry = $retry;
    }

    public function scoreCanRetry() {
        return $this->getScore() < $this->getTest()->getRetryMaxScore();
    }

    public function getStartedDate() {
        return new \DateTime($this->createdAt);
    }

    public function isExpired() {
        $elapsedTime = (strtotime('now') - $this->getStartedDate()->getTimestamp()) / 60;
        return $this->getTest()->getDuration() != '0' && $elapsedTime > $this->getTest()->getDuration();
    }

    public function getAnswers() {
        if ($this->answers == [] && $this->getId()) {
            $this->answers = (new AnswersRepository())->findAllByAttempt($this->getId());
        }
        return $this->answers;
    }

    public function clearCache() {
        $this->user = null;
        $this->test = null;
        $this->answers = [];
    }

    public function computeScore() {
        $score = 0;

        foreach ($this->getAnswers() as $answer) {
            if ($answer->isCorrect())
                $score += 1;
            else
                $score += $this->getTest()->getPenalty();
        }
        $this->score = $score;
        $this->pass = $this->testId ? $score >= $this->getTest()->getPassScore() : false;
        $this->retry = $this->testId ? $score < $this->getTest()->getRetryMaxScore() : true;
    }

    public function valid()
    {
        $this->errors = [];
        if (!isset($this->userId)) $this->errors['user_id'][] = 'The user must be defined';
        if (!isset($this->testId)) $this->errors['test_id'][] = 'The test must be defined';
        return (count($this->errors) == 0);
    }

    public function save()
    {
        if ($this->getId())
            return $this->update();
        $statement = $this->getPdo()->prepare("INSERT INTO testAttempts (user_id, test_id, score, pass, retry, created_at, updated_at) VALUES (:user_id, :test_id, :score, :pass, :retry, :created_at, :updated_at)");
        $statement->bindParam(':user_id', $this->userId);
        $statement->bindParam(':test_id', $this->testId);
        $statement->bindParam(':score', $this->score);
        $statement->bindParam(':pass', $this->pass, \PDO::PARAM_BOOL);
        $statement->bindParam(':retry', $this->retry, \PDO::PARAM_BOOL);
        $statement->bindParam(':created_at', date('Y-m-d H:i:s'));
        $statement->bindParam(':updated_at', date('Y-m-d H:i:s'));
        $statement->execute();
        $this->id = $this->getPdo()->lastInsertId();
    }

    public function update() {
        if (!$this->getId())
            return $this->save();
        $statement = $this->getPdo()->prepare("UPDATE testAttempts SET user_id = :user_id, test_id = :test_id, score = :score, pass = :pass, retry = :retry, updated_at = :updated_at WHERE id = :id");
        $statement->bindParam(':user_id', $this->userId);
        $statement->bindParam(':test_id', $this->testId);
        $statement->bindParam(':score', $this->score);
        $statement->bindParam(':pass', $this->pass, \PDO::PARAM_BOOL);
        $statement->bindParam(':retry', $this->retry, \PDO::PARAM_BOOL);
        $statement->bindParam(':id', $this->id);
        $statement->bindParam(':updated_at', date('Y-m-d H:i:s'));
        $statement->execute();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function applyCaseFormat() {
        if (!isset($this->userId) && isset($this->user_id)) $this->userId = $this->user_id;
        if (!isset($this->testId) && isset($this->test_id)) $this->testId = $this->test_id;
        if (!isset($this->createdAt) && isset($this->created_at)) $this->createdAt = $this->created_at;
        if (!isset($this->updatedAt) && isset($this->updated_at)) $this->updatedAt = $this->updated_at;
    }
}