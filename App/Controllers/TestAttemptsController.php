<?php

namespace App\Controllers;

use App\Models\TestAttempt;
use App\Repositories\TestAttemptsRepository;
use App\Repositories\TestRepository;
use Core\MVC\Controller;

class TestAttemptsController extends Controller {
    public function indexAction() {
        $test = (new TestRepository())->find($this->request()->getParameter('id'));
        $scores = (new TestAttemptsRepository())->findAllByTest($test->getId());
        return $this->render('TestAttempts/index.php', ['params' => [
            'scores' => $scores,
            'test' => $test
        ], 'template' => 'teacher.php']);
    }

    public function newAction() {
        return $this->render('TestAttempts/new.php', ['params' => [
            'test' => (new TestRepository())->find($this->request()->getParameters()['id'])
        ], 'template' => 'quizz.php']);
    }

    public function createAction() {
        $test = (new TestRepository())->find($this->request()->getParameter('id'));
        $attempts = (new TestAttemptsRepository())->findByTestAndUser($test->getId(), $this->get('security')->getUser()->getId());
        $best = null;
        if (count($attempts) == 0)
            return $this->create($test);
        foreach ($attempts as $attempt) {
            if ($best == null || $best->getScore() < $attempt->getScore())
                $best = $attempt;
            if ($attempt->canRetry())
                return $this->create($test);
        }
        return $this->render('TestAttempts/forbidden.php', ['params' => [
            'test' => $test,
            'attempt' => $attempt
        ]]);
    }

    public function showAction() {
        return $this->render('TestAttempts/show.php', ['params' => [
            'attempt' => (new TestAttemptsRepository())->find($this->request()->getParameter('attempt_id'))
        ], 'template' => 'quizz.php']);
    }

    private function create($test) {
        $attempt = new TestAttempt([
            'test_id' => $test->getId(),
            'user_id' => $this->get('security')->getUser()->getId(),
            'score' => 0,
            'retry' => true
        ]);
        if ($attempt->valid()) {
            (new TestAttemptsRepository())->blockRetake($this->get('security')->getUser()->getId(), $test->getId());
            $attempt->save();
        } else
            die(var_dump($attempt));
        return $this->redirect('/student/test/'.$test->getId().'/attempt/'.$attempt->getId());
    }

    public function reopenAction() {
        $attempt = (new TestAttemptsRepository())->find($this->request()->getParameter('attempt_id'));
        if ($attempt) {
            $attempt->setRetry(true);
            $attempt->save();
        }
        return $this->redirect('/teacher/test/'.$this->request()->getParameter('test_id').'/results');
    }
}