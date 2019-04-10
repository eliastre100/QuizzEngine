<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Core\MVC\View;
use Core\Request;

class SecurityService
{
    private $user = null;

    public function loadUser(Request $request)
    {
        if (isset($_SESSION['user'])) {
            $repository = new UserRepository();
            $this->user = $repository->find($_SESSION['user']);
        }
    }

    public function protectRoute(Request $request)
    {
        $route = $request->getRoute();
        if ($route != null && $route->getRoles() != []) {
            if (($this->user == null && count($route->getRoles()) >= 1) ||
                ($this->user != null && !in_array($this->user->getRole(), $route->getRoles()))) {
                $view = new View();
                $view->render(__DIR__ . '/../Views/Errors/unauthorized.php', ['status' => 403]);
                return $view;
            }
        }
        return null;
    }

    public function unsetUser()
    {
        unset($this->user);
        unset($_SESSION['user']);
    }

    public function setUser(User $user)
    {
        $this->user       = $user;
        $_SESSION['user'] = $user->getId();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getExports()
    {
        return ['user' => $this->getUser()];
    }
}