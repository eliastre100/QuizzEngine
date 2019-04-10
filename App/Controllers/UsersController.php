<?php

namespace App\Controllers;

use App\Models\User;
use Core\MVC\Controller;

class UsersController extends Controller {
    public function newAction() {
        return $this->render('Users/new.php', ['params' => [
            'user' => new User()
        ], 'template' => 'unauthenticated.php']);
    }

    public function createAction() {
        $user = new User($this->request()->getParameters());
        if ($user->valid()) {
            $user->save();
            $this->get('flash')->add('success', 'You account have been created. You can now log in');
            return $this->redirect('/login');
        } else {
            return $this->render('Users/new.php', ['params' => [
                'user' => $user
            ], 'template' => 'unauthenticated.php']);
        }
    }
}