<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Core\MVC\Controller;

class SessionController extends Controller {
    public function newAction() {
        return $this->render('Sessions/new.php', ['params' => [
            'user' => new User(),
            'errors' => []
        ], 'HTMLHeaders' => ['title' => 'Login'], 'template' => 'unauthenticated.php']);
    }

    public function createAction() {
        $repository = new UserRepository();
        $user = $repository->findOneByUsername($this->request()->getParameters()['username']);
        if ($user != null && $user->validatePassword($this->request()->getParameters()['password'])) {
            $this->get('security')->setUser($user);
            return $this->redirect('/student/dashboard');
        } else {
            return $this->render('Sessions/new.php', ['params' => [
                'user' => new User(['username' => $this->request()->getParameter('username')]),
                'errors' => ['Invalid username or password']
            ], 'template' => 'unauthenticated.php']);
        }
    }

    public function destroyAction() {
        $this->get('security')->unsetUser();
        $this->get('flash')->add('notice', 'You have been disconnected');
        return $this->redirect('/login');
    }
}
