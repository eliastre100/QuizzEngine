<?php

namespace App\Models;

use App\Repositories\QuestionsRepository;
use Core\MVC\Model;
use PDO;

class Answer extends Model {
    protected $id;
    protected $attempt_id;
    protected $attempt;
    protected $question_id;
    protected $question;
    protected $answer;
    protected $correct;
    private $errors;

    public function applyUpdates(array $attributes) {
        parent::applyUpdates($attributes);
        $this->importAnswers($attributes);
    }

    public function getQuestion() {
        if (!isset($this->question))
            $this->question = (new QuestionsRepository())->find($this->question_id);
        return $this->question;
    }

    public function isCorrect() {
        return $this->correct;
    }

    public function setAttempt($attempt) {
        $this->attempt_id = $attempt->getId();
        $this->attempt = $attempt;
    }

    public function setQuestion($question) {
        $this->question_id = $question->getId();
        $this->question = $question;
    }

    public function valid()
    {
        $this->errors = [];
        if (!is_array($this->answer)) $this->errors['answer'][] = 'The answers must be in an array';
        if (!isset($this->attempt_id)) $this->errors['attempt'][] = 'The answer must be bounded to an attempt';
        if (!isset($this->question_id)) $this->errors['question'][] = 'The answer must be bounded to a question';
        return count($this->errors) == 0;
    }

    public function getId() {
        return $this->id;
    }

    public function save()
    {
        if ($this->getId())
            return $this->update();
        $statement = $this->getPdo()->prepare("INSERT INTO answers (attempt_id, question_id, answer, correct) VALUES (:attempt_id, :question_id, :answer, :correct)");
        $statement->bindParam(':attempt_id', $this->attempt_id);
        $statement->bindParam(':question_id', $this->question_id);
        $statement->bindParam(':answer', serialize($this->answer));
        $statement->bindParam(':correct', $this->correct, PDO::PARAM_BOOL);
        $statement->execute();
        $this->id = $this->getPdo()->lastInsertId();
    }

    public function update() {
        if (!$this->getId())
            return $this->save();
        $statement = $this->getPdo()->prepare("UPDATE answers SET attempt_id = :attempt_id, question_id = :question_id, answer = :answer, correct = :correct WHERE answers.id = :id");
        $statement->bindParam(':attempt_id', $this->attempt_id);
        $statement->bindParam(':question_id', $this->question_id);
        $statement->bindParam(':answer', serialize($this->answer));
        $statement->bindParam(':correct', $this->correct, PDO::PARAM_BOOL);
        $statement->bindParam(':id', $this->getId());
        $statement->execute();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function check()
    {
        $question = $this->getQuestion();
        $validAnswers = array_column($question->getValidAnswers(), 'answer');
        if ($question->isMultiple()) {
            sort($validAnswers);
            sort($this->answer);
            $this->correct = $validAnswers == $this->answer;
        } else {
            $this->correct = in_array($this->answer[0], $validAnswers);
        }
    }

    private function importAnswers($attributes) {
        if (isset($attributes['answers']) && is_array($attributes['answers'])) {
            $this->answer = $attributes['answers'];
        } elseif (isset($attributes['answer'])) {
            $this->answer = [$attributes['answer']];
        } elseif (isset($this->answer)) {
            $this->answer = unserialize($this->answer);
        } else {
            $this->answer = [];
        }
    }
}