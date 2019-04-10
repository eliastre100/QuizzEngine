<?php

namespace Core;

use Core\MVC\Response;

class Request {
    private $route;

    public function setRoute(Route $route) {
        $this->route = $route;
        $this->addParams($route->generateMatch($this->getUri())['params']);
    }

    private function addParams($params) {
        $_REQUEST = array_merge($_REQUEST, $params);
    }

    public function getRoute(): Route {
        return $this->route;
    }

    public function respond(Response $response) {
        http_response_code($response->getStatus());
        foreach ($response->getHeaders() as $header) {
            header($header['name'].': '.$header['value']);
        }
        echo $response->getBoody();
        die();
    }

    public function getParameters() {
        return $_REQUEST;
    }

    public function getParameter($key) {
        return $this->getParameters()[$key];
    }

    public function hasParameter($key) {
        return isset($_REQUEST[$key]);
    }

    public function getPost() {
        return $_POST;
    }

    public function getUri() {
        $url = parse_url($_SERVER['REQUEST_URI']);
        return $url['path'];
    }

    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getHost() {
        return $_SERVER['HTTP_HOST'];
    }

    public function getProtocol()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            return 'https';
        } else {
            return 'http';
        }
    }

    public function getFromSession(string $key)
    {
        return $_SESSION[$key];
    }

    public function addToSession($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function clearFromSession($key) {
        unset($_SESSION[$key]);
    }
}