<?php

namespace Core\MVC;

use Core\Request;

class Controller {
    private $request;
    private $services = [];

    protected function request(): Request {
        return $this->request;
    }

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function render($template, $params = []): Response {
        $templateFile = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.$template;
        $view = new View();
        $view->render($templateFile, $params);
        return $view;
    }

    protected function redirect($uri): Response {
        $response = new Response(301, null);
        $uri = (substr($uri, 0, 4) == 'http') ? $uri : $this->request()->getProtocol().'://'.$this->request()->getHost() . path($uri);
        $response->addHeader('Location', $uri);
        return $response;
    }

    public function importServices($services) {
        $this->services = $services;
    }

    protected function get($service) {
        return $this->services[$service];
    }
}