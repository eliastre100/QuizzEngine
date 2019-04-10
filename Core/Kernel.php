<?php

namespace Core;

use Core\MVC\Response;

class Kernel {
    private $request;
    private $response;
    private $route;
    static private $beforeActions;
    static private $afterActions;
    static private $services;

    public static function registerBeforeAction($service, $method) {
        self::$beforeActions[] = [
            'service' => $service,
            'method' => $method
        ];
    }

    public static function registerAfterAction($service, $method) {
        self::$afterActions[] = [
            'service' => $service,
            'method' => $method
        ];
    }

    public static function registerService($name, $instance) {
        self::$services[$name] = $instance;
    }

    public static function getServicesExports() {
        $exports = [];
        foreach (Kernel::$services as $service) {
            $exports = array_merge($exports, $service->getExports());
        }
        return $exports;
    }

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function resolve() {
        $router = new Router();
        $this->route = $router->resolve($this->request);
        if ($this->route == null) {
            $this->error(404, 'No route found for ' . $this->request->getMethod() . ' ' . $this->request->getUri());
        }
        $this->request->setRoute($this->route['route']);
    }

    public function process() {
        $controller = new $this->route['controller']($this->request);
        $controller->importServices(self::$services);
        $action = $this->route['action'].'Action';
        $this->response = $controller->$action($this->route['params']);
    }

    public function error($code, $message) {
        $this->response = new Response($code, $message);
        $this->respond();
    }

    public function processBeforeActions() {
        foreach (self::$beforeActions as $beforeAction) {
            $service = self::$services[$beforeAction['service']];
            $method = $beforeAction['method'];
            $result = $service->$method($this->request);
            if ($result instanceof Response) {
                $this->response = $result;
                $this->respond();
            }
        }
    }

    public function processAfterActions() {
        foreach (self::$afterActions as $afterAction) {
            $service = self::$services[$afterAction['service']];
            $method = $afterAction['method'];
            $service->$method($this->request);
        }
    }

    public function respond() {
        $this->request->respond($this->response);
    }
}