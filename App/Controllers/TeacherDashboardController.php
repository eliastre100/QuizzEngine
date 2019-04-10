<?php

namespace App\Controllers;

use App\Repositories\TestRepository;
use Core\MVC\Controller;

class TeacherDashboardController extends Controller {
    public function indexAction() {
        return $this->render('Teacher/dashboard.php', ['params' => [
            'user' => $this->get('security')->getUser(),
            'tests' => (new TestRepository())->findAll()
        ], 'template' => 'teacher.php']);
    }
}