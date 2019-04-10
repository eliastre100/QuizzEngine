<?php

namespace App\Controllers;

use App\Repositories\TestAttemptsRepository;
use App\Repositories\TestRepository;
use Core\MVC\Controller;

class StudentDashboardController extends Controller {
    public function indexAction() {
        $user = $this->get('security')->getUser();
        return $this->render('Student/dashboard.php', ['params' => [
            'user' => $user,
            'unansweredTests' => (new TestRepository())->findNonAnsweredTestsByStatus($user->getId(), true),
            'scores' => (new TestAttemptsRepository())->findAllByUser($user->getId())
        ], 'template' => 'student.php']);
    }
}