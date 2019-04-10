<?php

namespace App\Controllers;

use App\Models\Test;
use App\Repositories\TestRepository;
use Core\MVC\Controller;

class TestsController extends Controller {
    public function newAction() {
        return $this->render('Tests/new.php', [ 'params' => [
            'test' => new Test()
        ], 'template' => 'teacher.php']);
    }

    public function createAction() {
        $test = new Test($this->request()->getParameters());

        if ($test->valid()) {
            $test->save();
            return $this->redirect('/teacher/dashboard');
        } else {
            return $this->render('Tests/new.php', ['params' => [
                'test' => $test
            ], 'template' => 'teacher.php']);
        }
    }

    public function editAction() {
        return $this->render('Tests/new.php', [ 'params' => [
            'test' => (new TestRepository())->find($this->request()->getParameter('id'))
        ], 'template' => 'teacher.php']);
    }

    public function updateAction() {
        $test = (new TestRepository())->find($this->request()->getParameter('id'));
        $test->applyUpdates($this->request()->getParameters());
        if ($test->valid()) {
            $test->save();
            return $this->redirect('/teacher/test/'.$test->getId());
        } else {
            return $this->render('Tests/edit.php', ['params' => [
                'test' => $test
            ]]);
        }
    }

    public function showAction() {
        $test = (new TestRepository())->find($this->request()->getParameters()['id']);
        if (!$test) {
            return $this->render('Errors/not_found.php', ['status' => 404]);
        }
        return $this->render('Tests/show.php', ['params' => [
            'test' => $test
        ], 'template' => 'teacher.php']);
    }

    public function destroyAction() {
        $test = (new TestRepository())->find($this->request()->getParameters()['id']);
        if ($test) {
            $test->destroy();
            $this->get('flash')->add('notice', 'The test '.$test->getTitle().' have successfully been deleted');
        }
        return $this->redirect('/teacher/dashboard');
    }
}