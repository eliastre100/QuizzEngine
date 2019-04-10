<?php

namespace App\Models;

use App\Repositories\TestRepository;
use Core\MVC\Model;
use PDO;

class Question extends Model {
    protected $id;
    protected $question;
    protected $answers = [];
    protected $multiple;
    protected $test_id;
    protected $test;
    private $errors;

    public function applyUpdates(array $attributes) {
        parent::applyUpdates($attributes);
        $this->handleCheckboxChanges($attributes);
        $this->importAnswers($attributes);
    }

    public function valid()
    {
        $this->errors = [];
        if (empty($this->question)) $this->errors['question'][] = 'The question must be defined';
        if (count($this->answers) < 1) $this->errors['answers'][] = 'At least one answer is required';
        if (!in_array(true, array_column($this->answers, 'valid'))) $this->errors['answers'][] = 'At least one answer must be valid';
        if (!$this->isValidAnswersPresentInAnswers()) $this->errors['validAnswers'][] = 'All valid answers have to be also an answer';
        return count($this->errors) == 0;
    }

    public function getId() {
        return $this->id;
    }

    public function getAnswers() {
        return $this->answers;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function isMultiple() {
        return $this->multiple != null && $this->multiple;
    }

    public function setTest(Test $test) {
        $this->test = $test;
        $this->test_id = $test->getId();
    }

    public function getTest() {
        if (!isset($this->test)) {
            $this->test = (new TestRepository())->find($this->test_id);
        }
        return $this->test;
    }

    public function save()
    {
        if ($this->getId())
            return $this->update();
        $statement = $this->getPdo()->prepare("INSERT INTO questions (question, multiple, answers, test_id) VALUES (:question, :multiple, :answers, :test_id)");
        $statement->bindParam(':question', $this->question);
        $statement->bindParam(':multiple', $this->isMultiple(), PDO::PARAM_BOOL);
        $statement->bindParam(':answers', serialize($this->answers));
        $statement->bindParam(':test_id', $this->test_id);
        $statement->execute();
        $this->id = $this->getPdo()->lastInsertId();
    }

    public function update() {
        if (!$this->getId())
            return $this->save();
        $statement = $this->getPdo()->prepare("UPDATE questions SET question = :question, multiple = :multiple, answers = :answers WHERE questions.id = :id");
        $statement->bindParam(':question', $this->question);
        $statement->bindParam(':multiple', $this->isMultiple(), PDO::PARAM_BOOL);
        $statement->bindParam(':answers', serialize($this->answers));
        $statement->bindParam(':id', $this->getId());
        $statement->execute();
    }

    public function destroy()
    {
        $statement = $this->getPdo()->prepare("DELETE FROM questions WHERE questions.id = :id");
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

    public function getValidAnswers() {
        return array_filter($this->answers, function ($answer) {
            return $answer['valid'];
        });
    }

    private function importAnswers($answers) {
        if (isset($answers['answers']) && is_array($answers['answers'])) {
            $this->answers = [];
            foreach ($answers['answers'] as $answer) {
                if ($answer['answer'] != '') {
                    $this->answers[] = [
                        'answer' => $answer['answer'],
                        'valid' => ($answer['valid'] != null && $answer['valid'] != 'off')
                    ];
                }
            }
        } else if (!empty($this->answers)) {
            $answers = @unserialize($this->answers);
            if ($answers)
                $this->answers = $answers;
        }
    }

    private function isValidAnswersPresentInAnswers() {
        foreach ($this->validAnswers as $answer) {
            if (!in_array($answer, $this->answers))
                return false;
        }
        return true;
    }

    private function handleCheckboxChanges(array $attributes)
    {
        if ($attributes != []) {
            $this->multiple = isset($attributes['multiple']) && $attributes['multiple'] != 'off';
        }
    }
}