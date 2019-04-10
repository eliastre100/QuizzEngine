<?php

namespace App\Controllers;

use App\Models\Question;
use App\Repositories\QuestionsRepository;
use App\Repositories\TestRepository;
use Core\MVC\Controller;

class QuestionsController extends Controller {
    private $test;

    public function newAction() {
        $question = new Question();
        $question->setTest($this->getTest());
        return $this->render('Questions/new.php', ['params' => [
            'question' => $question
        ], 'template' => 'teacher.php']);
    }

    public function createAction() {
        $question = new Question($this->request()->getParameters());
        $question->setTest($this->getTest());
        if (empty($this->request()->getParameter('addNewAnswer')) && $question->valid()) {
            $question->save();
            return $this->redirect('/teacher/test/'.$this->getTest()->getId());
        }
        return $this->render('Questions/new.php', ['params' => [
            'question' => $question
        ], 'template' => 'teacher.php']);
    }

    public function editAction() {
        $question = (new QuestionsRepository())->find($this->request()->getParameter('id'));
        return $this->render('Questions/edit.php', ['params' => [
            'question' => $question
        ], 'template' => 'teacher.php']);
    }

    public function updateAction() {
        $question = (new QuestionsRepository())->find($this->request()->getParameter('id'));
        $question->applyUpdates($this->request()->getParameters());
        if (empty($this->request()->getParameter('addNewAnswer')) && $question->valid()) {
            $question->save();
            return $this->redirect('/teacher/test/'.$this->getTest()->getId());
        }
        return $this->render('Questions/new.php', ['params' => [
            'question' => $question
        ], 'template' => 'teacher.php']);
    }

    public function destroyAction() {
        $question = (new QuestionsRepository())->find($this->request()->getParameter('id'));
        if ($question) {
            $question->destroy();
            $this->get('flash')->add('notice', 'The question have successfully been deleted');
        }
        return $this->redirect('/teacher/test/'.$question->getTest()->getId());
    }

    private function getTest() {
        if (!isset($this->test)) {
            $this->test = (new TestRepository())->find($this->request()->getParameters()['test_id']);
        }
        return $this->test;
    }
}