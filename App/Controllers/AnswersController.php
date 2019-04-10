<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Repositories\AnswersRepository;
use App\Repositories\QuestionsRepository;
use App\Repositories\TestAttemptsRepository;
use App\Repositories\TestRepository;
use Core\MVC\Controller;

class AnswersController extends Controller {
    private function beforeAction() {
        $this->test = (new TestRepository())->find($this->request()->getParameter('test_id'));
        $this->attempt = (new TestAttemptsRepository())->find($this->request()->getParameter('attempt_id'));
        if ($this->request()->hasParameter('question_id'))
            $this->question = (new QuestionsRepository())->find($this->request()->getParameter('question_id'));
    }

    public function newAction() {
        $this->beforeAction();
        $questionsRepository = new QuestionsRepository();
        $questions = $questionsRepository->findAttemptRemaining($this->attempt);
        $nbrQuestions = count($questions);
        if ($nbrQuestions < 1 || $this->attempt->isExpired() ) {
            return $this->redirect('/student/test/'.$this->test->getId().'/attempt/'.$this->attempt->getId().'/results');
        } else {
            return $this->render('Answers/new.php', ['params' => [
                'test' => $this->test,
                'attempt' => $this->attempt,
                'question' => $questions[rand(0, $nbrQuestions - 1)]
            ], 'template' => 'quizz.php']);
        }
    }

    public function createAction() {
        $this->beforeAction();
        $preflight = $this->preflightChecks();
        if ($preflight != null) return $preflight;
        $answer = new Answer($this->request()->getParameters());
        $answer->setQuestion($this->question);
        $answer->setAttempt($this->attempt);
        $answer->check();
        if ($answer->valid()) {
            $answer->save();
            $this->attempt->clearCache();
            $this->attempt->computeScore();
            $this->attempt->save();
            return $this->redirect('/student/test/'.$this->test->getId().'/attempt/'.$this->attempt->getId());
        } else {
            throw new \Exception('Unable to save answer', 500);
        }
    }

    private function preflightChecks() {
        $attemptUrl = '/student/test/'.$this->test->getId().'/attempt/'.$this->attempt->getId();
        if ($this->attempt->getUser() != $this->get('security')->getUser()) return $this->redirect('/login');
        if (!isset($this->question)) return $this->redirect($attemptUrl); // We have a question to answer
        if ($this->question->getTest() != $this->test) return $this->redirect($attemptUrl); // The question we answer is in the test
        if ($this->attempt->getTest() != $this->test) return $this->redirect('/student/dashboard'); // The attempt is on the correct test

        $previousAnswer = (new AnswersRepository())->findAllByAttemptAndQuestion($this->attempt->getId(), $this->question->getId());
        if ($previousAnswer) return $this->redirect($attemptUrl); // The question was already answered
        if ($this->attempt->isExpired()) return $this->redirect($attemptUrl); // The test is ended

        return null;
    }
}
